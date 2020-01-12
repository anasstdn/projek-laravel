<?php 
function bulan($bln)
{
    switch ($bln)
    {
        case 1:
        return "Januari";
        break;
        case 2:
        return "Februari";
        break;
        case 3:
        return "Maret";
        break;
        case 4:
        return "April";
        break;
        case 5:
        return "Mei";
        break;
        case 6:
        return "Juni";
        break;
        case 7:
        return "Juli";
        break;
        case 8:
        return "Agustus";
        break;
        case 9:
        return "September";
        break;
        case 10:
        return "Oktober";
        break;
        case 11:
        return "November";
        break;
        case 12:
        return "Desember";
        break;
    }
}

function date_indo($tgl)
{
    $ubah = gmdate($tgl, time()+60*60*8);
    $pecah = explode("-",$ubah);
    $tanggal = $pecah[2];
    $bulan = bulan($pecah[1]);
    $tahun = $pecah[0];
    return $tanggal.' '.$bulan.' '.$tahun;
}

function column_name($name)
{
	switch($name)
	{
		case 'pasir':
		return 'Pasir';
		break;
		case 'gendol':
		return 'Gendol';
		break;
		case 'abu':
		return 'Abu';
		break;
		case 'split2_3':
		return 'Split 2/3';
		break;
		case 'split1_2':
		return 'Split 1/2';
		break;
		case 'lpa':
		return 'LPA';
		break;
	}
}

?>