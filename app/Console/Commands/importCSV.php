<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use Carbon\Carbon;

Use App\AssignmentGroup;
Use App\Incident;

class importCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv {csvFile} {assignmentGroup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csvFile = $this->argument('csvFile');
        // $fp = fopen($csvFile, "r");
        // while($line = fgetcsv($fp,  0, ",", "\"", "\"")) {
        //     if(!isset($line[2])) {
        //         var_dump($line);
        //     }else {
        //         echo $line["2"] . "\n";
        //     }
            
        // }
        // die;

        $assignmentGroup = AssignmentGroup::where('group_name', $this->argument('assignmentGroup'))->firstOrFail();
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setEscape("");
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader(); //returns the CSV header record
        foreach($csv->getRecords() as $record) {

            $incident = new Incident;
            $incident->incident = $record['number'];

            $incident->short_description = iconv("UTF-8","UTF-8//IGNORE",$record['short_description']);
            $incident->opened_at = Carbon::parse($record['opened_at']);
            $incident->closed_at = Carbon::parse($record['closed_at']);
            $incident->service_offering_name = $record['service_offering.name'];
            
            $openedBy = $record['opened_by'];
            preg_match("/\((.*?)\)/", $openedBy, $matches);
            if(count($matches) > 0) {
                $internetId = $matches[1];
                $name = str_replace("()", "", str_replace($internetId, "", $openedBy));
                $incident->opened_by_name = $name;
                $incident->opened_by_internet_id = $internetId;
            }
            else {
                $incident->opened_by_name = $openedBy;
            }

            $incident->work_notes_and_comments = iconv("UTF-8","UTF-8//IGNORE",$record['u_comments_and_work_notes']);
            $incident->close_notes = iconv("UTF-8","UTF-8//IGNORE",$record['close_notes']);
            $searchField = implode(" ", [$incident->short_description, $incident->work_notes_and_comments,  $incident->close_notes]);
            $reservedSymbols = [".", "/","-", '+', '<', '>', '@', '(', ')', '~'];
            $searchField = str_replace($reservedSymbols, '', $searchField);
            $incident->search = $searchField;
            $incident->assignmentGroup()->associate($assignmentGroup);
            $incident->save();
        }



    }
}
