<?php
    // Format JSON
    header('Content-Type: application/json');

    // Koneksi database
    include "../../_Config/Connection.php";

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Response helper
    function sendResponse($data, $statusCode = 200){
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    try {
        // Validasi input
        $periode = $_POST['periode'] ?? 'Tahun';
        $tahun   = $_POST['tahun'] ?? date('Y');
        $bulan   = $_POST['bulan'] ?? date('m');

        $result = [];

        /*
        |--------------------------------------------------------------------------
        | GRAFIK PER TAHUN
        | Output: Januari - Desember
        |--------------------------------------------------------------------------
        */
        if ($periode == "Tahun") {

            $stmt = $Conn->prepare("
                SELECT 
                    MONTH(`timestamp`) as bulan,
                    COUNT(*) as viewer
                FROM visitor_logs
                WHERE YEAR(`timestamp`) = :tahun
                GROUP BY MONTH(`timestamp`)
                ORDER BY MONTH(`timestamp`) ASC
            ");
            $stmt->execute(['tahun' => $tahun]);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Default 12 bulan = 0
            $dataBulan = [];
            for ($i = 1; $i <= 12; $i++) {
                $dataBulan[$i] = 0;
            }

            // Isi data dari database
            foreach ($rows as $row) {
                $dataBulan[(int)$row['bulan']] = (int)$row['viewer'];
            }

            // Nama bulan
            $namaBulan = [
                1 => "Jan",
                2 => "Feb",
                3 => "Mar",
                4 => "Apr",
                5 => "Mei",
                6 => "Jun",
                7 => "Jul",
                8 => "Agu",
                9 => "Sep",
                10 => "Okt",
                11 => "Nov",
                12 => "Des"
            ];

            foreach ($dataBulan as $bulanNum => $viewer) {
                $result[] = [
                    'bulan_label' => $namaBulan[$bulanNum],
                    'viewer'      => $viewer
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GRAFIK PER BULAN
        | Output: tanggal 1 - akhir bulan
        |--------------------------------------------------------------------------
        */
        elseif ($periode == "Bulan") {

            $stmt = $Conn->prepare("
                SELECT 
                    DAY(`timestamp`) as tanggal,
                    COUNT(*) as viewer
                FROM visitor_logs
                WHERE YEAR(`timestamp`) = :tahun
                AND MONTH(`timestamp`) = :bulan
                GROUP BY DAY(`timestamp`)
                ORDER BY DAY(`timestamp`) ASC
            ");
            $stmt->execute([
                'tahun' => $tahun,
                'bulan' => $bulan
            ]);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Jumlah hari dalam bulan
            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, (int)$bulan, (int)$tahun);

            // Default semua hari = 0
            $dataHari = [];
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $dataHari[$i] = 0;
            }

            // Isi data dari database
            foreach ($rows as $row) {
                $dataHari[(int)$row['tanggal']] = (int)$row['viewer'];
            }

            foreach ($dataHari as $tanggal => $viewer) {
                $result[] = [
                    'tanggal' => $tanggal,
                    'viewer'  => $viewer
                ];
            }
        }

        sendResponse([
            'status' => 'success',
            'data'   => $result
        ], 200);

    } catch (PDOException $e) {
        sendResponse([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
?>