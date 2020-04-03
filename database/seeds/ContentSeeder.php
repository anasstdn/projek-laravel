<?php
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Seeder;
use App\Models\RawDatum;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
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
    	// $this->importData();
        $this->importWilayah();
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

    private function importWilayah()
    {
        $this->command->info("Hapus Provinsi");
        DB::table('provinsi')->delete();
        $fileName = 'data/provinsi.xlsx';
        $this->command->info("Seeding Provinsi");
        \Excel::load($fileName,function($reader){
        // $reader->dump();
            $reader->each(function($row){
              $bar = $this->command->getOutput()->createProgressBar($row->count());
          // die("hasil = ".$row->count());

              $row->each(function($provinsi) use ($bar){
            // echo ($provinsi['kode']."\n");


                if(isset($provinsi['id'])){
                  $data = Provinsi::firstOrNew(array(
                    'id'=>$provinsi['id'],
                    'kd_provinsi'=>$provinsi['kd_provinsi']
                ));
                  $data->provinsi=$provinsi['provinsi'];
                  $data->save();
              }
              $bar->advance();
          });
              $bar->finish();

          });
        });
        echo "\n\n";

        $this->command->info("Hapus Kabupaten");
        DB::table('kabupaten')->delete();
        $fileName = 'data/kabupaten.xlsx';
        $this->command->info("Seeding Kabupaten");
        \Excel::load($fileName,function($reader){
        // $reader->dump();
            $reader->each(function($row){
              $bar = $this->command->getOutput()->createProgressBar($row->count());
              $row->each(function($kabupaten) use ($bar){
            // echo ($kabupaten['kode']."\n");
                if(isset($kabupaten['id'])){

                  $data = Kabupaten::firstOrNew(array(
                    'kd_kabupaten'=>$kabupaten['kd_kabupaten'],
                    'id'=>$kabupaten['id']

                ));
                  $data->id_provinsi=$kabupaten['id_provinsi'];
                  $data->kabupaten=$kabupaten['kabupaten'];
                  $data->save();

              }
              $bar->advance();
          });
              $bar->finish();
          });
        });
        echo "\n\n";

        $this->command->info("Hapus Kecamatan");
        DB::table('kecamatan')->delete();
        $fileName = 'data/kecamatan.xlsx';
        $this->command->info("Seeding Kecamatan");
        \Excel::load($fileName,function($reader){
            $reader->each(function($row){
              $bar = $this->command->getOutput()->createProgressBar($row->count());
              $row->each(function($kecamatan) use ($bar){
                if(isset($kecamatan['id'])){

                  $data = Kecamatan::firstOrNew(array(
                    'kd_kecamatan'=>$kecamatan['kd_kecamatan'],
                    'id'=>$kecamatan['id']

                ));
                  $data->id_kabupaten=$kecamatan['id_kabupaten'];
                  $data->kecamatan=$kecamatan['kecamatan'];
                  $data->save();

              }
              $bar->advance();
          });
              $bar->finish();
          });
        });
        echo "\n\n";

        $this->command->info("Hapus Kelurahan");
        DB::table('kelurahan')->delete();
        $fileName = 'data/kelurahan.xlsx';
        $this->command->info("Seeding kelurahan");
        \Excel::load($fileName,function($reader){
            $reader->each(function($row){
              $bar = $this->command->getOutput()->createProgressBar($row->count());
              $row->each(function($kelurahan) use ($bar){
                if(isset($kelurahan['id'])){

                  $data = Kelurahan::firstOrNew(array(
                    'kd_kelurahan'=>$kelurahan['kd_kelurahan'],
                    'id'=>$kelurahan['id']

                ));
                  $data->id_kecamatan=$kelurahan['id_kecamatan'];
                  $data->kelurahan=$kelurahan['kelurahan'];
                  $data->kodepos=$kelurahan['kode_pos'];
                  $data->save();

              }
              $bar->advance();
          });
              $bar->finish();
          });
        });
        echo "\n\n";
    }
}
