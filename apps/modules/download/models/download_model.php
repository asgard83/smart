<?php

class Download_model extends CI_Model{

    public function setDownloadInspection($id)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $this->load->library('newphpexcel');

            $qTmInspection = "SELECT CONVERT(VARCHAR(10), A.INSPECTION_DATE_START, 103) AS INSPECTION_DATE_START,
                              CONVERT(VARCHAR(10), A.INSPECTION_DATE_END, 103) AS INSPECTION_DATE_END, B.BBPOM_NAME
                              FROM TM_INSPECTION A
                              LEFT JOIN TR_BBPOM B ON A.BBPOM_ID = B.BBPOM_ID
                              WHERE A.INSPECTION_ID = " . $id;
            $dTmInspection = $this->main->get_result($qTmInspection);
            if($dTmInspection)
            {
                foreach($qTmInspection->result_array() as $rowTmInspection)
                {
                    $awal   = $rowTmInspection['INSPECTION_DATE_START'];
                    $akhir  = $rowTmInspection['INSPECTION_DATE_END'];
                    $balai  = $rowTmInspection['BBPOM_NAME'];
                }
            }

            $this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->mergecell(array(array('A1','I1'),array('A2','B2'),array('A3','B3'),array('A4','B4'),array('A5','B5')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',30),array('C',30),array('D',25),array('E',20),array('F',60),array('G',20),array('H',30),array('I',30)));
			$this->newphpexcel->set_bold(array('A1','C2','C5'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN HASIL PEMERIKSAAN SARANA DISTRIBUSI OBAT PT DAN PKRT')
                              ->setCellValue('A3', 'Pemeriksaan Awal')
                              ->setCellValue('C3', $awal)
                              ->setCellValue('A4', 'Pemeriksaan Akhir')
                              ->setCellValue('C4', $akhir)
                              ->setCellValue('A5', 'Balai Besar / Balai POM')
                              ->setCellValue('C5', $balai);

			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A7','No.')
                              ->setCellValue('B7','Nama Sarana')
                              ->setCellValue('C7','Alamat')
                              ->setCellValue('D7','Tanggal Periksa')
                              ->setCellValue('E7','Tujuan Periksa')
                              ->setCellValue('F7','Hasil Temuan')
                              ->setCellValue('G7','Hasil Balai')
                              ->setCellValue('H7','Tindak Lanjut Balai')
                              ->setCellValue('I7','Keterangan');
			$this->newphpexcel->headings(array('A7','B7','C7','D7','E7','F7','G7','H7','I7'));
			$this->newphpexcel->set_wrap(array('B','F','C'));

            $qTmInspectionDetail = "SELECT LTRIM(RTRIM(UPPER(REPLACE(A.TRADER_NAME,'-','')))) AS TRADER_NAME, 
                                    CAST(A.TRADER_ADDRESS_1 +' '+ C.REGION_NAME +' '+ B.REGION_NAME AS VARCHAR(255)) AS TRADER_ADDRESS, CONVERT(VARCHAR(10), D.INSPECTION_DATE_START, 103) + ' s.d ' + CONVERT(VARCHAR(10), D.INSPECTION_DATE_END, 103) AS [TANGGAL], E.TUJUAN_PEMERIKSAAN, E.HASIL_TEMUAN, D.INSPECTION_RESULT, D.INSPECTION_BPOM_RESULT, E.KLASIFIKASI_PELANGGARAN_MAJOR AS MAJOR, E.KLASIFIKASI_PELANGGARAN_MINOR AS MINOR, E.KLASIFIKASI_PELANGGARAN_CRITICAL AS KRITIKAL, E.KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE AS CA, E.KASUS_POINT_A, E.KASUS_POINT_B, E.KASUS_POINT_D, E.KASUS_POINT_E, E.KASUS_POINT_F, E.KASUS_POINT_G, E.KASUS_POINT_H, E.TINDAK_LANJUT_BALAI, E.DETAIL_TINDAK_LANJUT_BALAI, E.TINDAK_LANJUT_PUSAT, E.DETIL_TINDAK_LANJUT_PUSAT, G.BBPOM_NAME 
                                    FROM TM_TRADER A 
                                    LEFT JOIN TR_REGION B ON A.PROVINCE_ID = B.REGION_ID
                                    LEFT JOIN TR_REGION C ON A.REGION_ID = C.REGION_ID
                                    LEFT JOIN TM_INSPECTION D ON A.TRADER_ID = D.TRADER_ID
                                    LEFT JOIN TM_INSPECTION_DISTRIBUTION E ON D.INSPECTION_ID = E.INSPECTION_ID
                                    LEFT JOIN TR_BBPOM G ON D.BBPOM_ID = G.BBPOM_ID
                                    WHERE
                                    D.INSPECTION_ID = ". $id;
			$dTmInspectionDetail = $this->main->get_result($qTmInspectionDetail);
			$no=1;
			$rec = 8;
			if($dTmInspectionDetail)
            {
				foreach($qTmInspectionDetail->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
                         ->setCellValue('B'.$rec,strtoupper($row["TRADER_NAME"]))
                         ->setCellValue('C'.$rec,$row["TRADER_ADDRESS"])
                         ->setCellValue('D'.$rec,$row["TANGGAL"])
                         ->setCellValue('E'.$rec,$row["TUJUAN_PEMERIKSAAN"])
                         ->setCellValue('F'.$rec,str_replace("___","; ",$row["HASIL_TEMUAN"]))
                         ->setCellValue('G'.$rec,$row["INSPECTION_RESULT"])
                         ->setCellValue('H'.$rec,str_replace("#","; ",$row["TINDAK_LANJUT_BALAI"]))
                         ->setCellValue('I'.$rec,$row["DETAIL_TINDAK_LANJUT_BALAI"]);
                         $this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
                }
			}
            else
            {
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:I8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}
			ob_clean();
			$file = "smrtbpm-".date("YmdHis").".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=$file");
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5'); 
			$objWriter->save('php://output');
			exit();	                        
        }
    }

    public function setDownloadLetterRecom($id) 
    {
        if($this->newsession->userdata('isLogin'))
		{
            require_once(APPPATH.'third_party/PHPWord.php');			
			$PHPWord = new PHPWord();
			$document = $PHPWord->loadTemplate('template/Laporan_Hasil_Pemeriksaan_Sarana.docx');
            
			$document->setValue('NOMOR_SURAT', 'PR.0001.0001');
			$document->setValue('TANGGAL_SURAT', '5 Juni 2017');
			$document->setValue('LAMPIRAN', '1 berkas');
			$document->setValue('PERIHAL', 'Laporan Hasil Pemeriksaan Sarana Distribusi/Pelayanan Produk Terapetik dan Napza Bulan Juni 2017');
			$document->setValue('KEPALA_DINAS', 'Kepala Dinas Kota Tangerang');
			$document->setValue('ALAMAT_DINAS', 'Jl. Daan Mogot No. 69');
			$document->setValue('KOTA_DINAS', 'Kota Tangerang');
			$document->setValue('NAMA_BBPOM', 'Balai POM Di Serang');
			$document->setValue('BULAN_INSPEKSI', 'Juni');
			$document->setValue('TAHUN_INSPEKSI', '2017');
			$document->setValue('NAMA_KEPALA_BBPOM', 'Kepala BPOM Di Serang');
			$document->setValue('NIP_KEPALA_BBPOM', '1234567890');
			$document->setValue('TEMBUSAN', '1. Direktur Pengawasan Produk Napza Badan POM RI');

			$filename = 'SmrtBPMRcm'.date('Ymdhis').'.docx';
			$document->save($filename);
			header("Content-type: application/vnd.ms-word");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=$filename");
			ob_clean();
			flush();
			readfile($filename);
			unlink($filename);
            

            // $section = $PHPWord->createSection();

            // // After creating a section, you can append elements:
            // $section->addText('Hello world!');

            // // You can directly style your text by giving the addText function an array:
            // $section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));

            // // If you often need the same style again you can create a user defined style to the word document
            // // and give the addText function the name of the style:
            // $PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
            // $section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');
            
            // // At least write the document to webspace:
            // $fileName = './template/helloWorld.docx';
            // $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
            // $objWriter->save($fileName);
        }
    }

}