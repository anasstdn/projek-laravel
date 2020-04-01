<?php
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Seeder;
use App\Models\RawDatum;
use Carbon\Carbon;
date_default_timezone_set("Asia/Jakarta");

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	$this->importData();
    }


    private function importData()
    {
    	$this->command->info('Delete Data Penjualan');
    	DB::table('raw_data')->delete();
        DB::statement("ALTER TABLE raw_data AUTO_INCREMENT = 1;");
    	$fileName = 'data/data_import.xlsx';
    	$this->command->info("Seeding Data Penjualan");
    	\Excel::load($fileName,function($reader){
        // $reader->dump();
    		$reader->each(function($row){
    			$bar = $this->command->getOutput()->createProgressBar($row->count());
          // die("hasil = ".$row->count());
    			$row->each(function($value) use ($bar){
            // echo ($provinsi['kode']."\n");
    				$data = RawDatum::firstOrNew(array(

    					'tgl_transaksi' => Carbon::parse($value['tgl_transaksi'])->format('Y-m-d'), 
    					'no_nota' => $value['no_nota'],
    					'pasir'=>$value['pasir'],
    					'gendol'=>$value['gendol'],
    					'abu'=>$value['abu'],
    					'split2_3'=>$value['split2_3'],
    					'split1_2'=>$value['split1_2'],
    					'lpa'=>$value['lpa'],
                        'campur'=>$value['campur'],
    					'created_at'=>date('Y-m-d H:i:s')
    				));

    				$data->save();
    				$bar->advance();
    			});
    			$bar->finish();

    		});
    	});
    	echo "\n\n";
    }
}
