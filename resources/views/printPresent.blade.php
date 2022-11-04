<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .tableRecap {
            --bs-table-bg: transparent;
            --bs-table-accent-bg: transparent;
            --bs-table-striped-color: #212529;
            --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
            --bs-table-active-color: #212529;
            --bs-table-active-bg: rgba(0, 0, 0, 0.1);
            --bs-table-hover-color: #212529;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
            width: 20%;
            margin-bottom: 1rem;
            color: #212529;
        }
    </style>
    <title>Rekapitulasi Daftar Kehadiran Staff</title>
  </head>
<body>
    <div class="container">
    <!-- Content here -->
    <h2 class="text-center" id="judul"></h2>
    <table>
        <tr>
            <td>Nama </td>
            <td>:</td>
            <td>{{ $pinStaff->name }}</td>
        </tr>
        <tr>
            <td>Pin </td>
            <td>:</td>
            <td>{{ $pinStaff->pin }}</td>
        </tr>
        <tr>
            <td>Jabatan </td>
            <td>:</td>
            <td>{{ $pinStaff->position }}</td>
        </tr>
    </table>
    <table class="table table-bordered border-dark">
    <head>
        <tr>
            <th class="dateCell" rowspan="2">No</th>
            <th rowspan="2">Hari</th>
            <th rowspan="2">Tanggal</th>
            <th colspan="2">Jam Kerja</th>
            <th colspan="2">Rekaman Presensi</th>
            <th rowspan="2">Keterangan</th>
            <th colspan="3">Terlambat (TL)</th>
            <th colspan="3">Pulang Sebelum Waktunya (PSW)</th>
        </tr>
        <tr>
            <th>Datang</th>
            <th>Pulang</th>
            <th>Datang</th>
            <th>Pulang</th>
            <th>TL1</th>
            <th>TL2</th>
            <th>TL3</th>
            <th>PSW1</th>
            <th>PSW2</th>
            <th>PSW3</th>
        </tr>
    </head>
    <tbody id="tableBody">
    </tbody>
    </table>
    <table class="tableRecap table-bordered border-dark">
    <head>
        <tr>
            <th class="dateCell" rowspan="2">Uraian</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <th>Hari</th>
        </tr>
    </head>
    <tbody id="tableRecap">
    </tbody>
    </table>
    </div>

    @php
        $dimensi = 0;
    @endphp

    @foreach($pinPresent as $a)
        @php
            $dimensi++;
        @endphp
    @endforeach
    
    <script type="text/javascript">
        var mount = '<?= $month ?>';
        var year = '<?= $year ?>'
        var dataPresent = <?php echo json_encode($pinPresent); ?>;
        var time = <?php echo json_encode($time); ?>;
        var dimensi = '<?= $dimensi ?>';

        var timeIn = time[0]['in'].split(":");
        var timeOut = time[0]['out'].split(":");
        
        getMonth(mount,year)

        const bulan = ["Januari", "Februari", "Maret", "April", "Mai", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember"];
        document.getElementById("judul").innerHTML = "Rekap Daftar Kehadiran kepegawaian Bulan " + bulan[mount-1];
    
    function formatDate(d) {
        var z = x => ('0'+x).slice(-2);
        return z(d.getDate()) + '-' + z(d.getMonth()+1) + '-' + d.getFullYear();
    }
    
    function formatClock(d) {
        var z = x => ('0'+x).slice(-2);
        return z(d.getHours()) + ':' + z(d.getMinutes()) + ':' + d.getSeconds();
    }

    function formatHours(h,m,s) {
        var z = x => ('0'+x).slice(-2);
        return z(h) + ':' + z(m) + ':' + s;
    }

    function formatTelat(duration) {
        var milliseconds = Math.floor((duration % 1000) / 100),
        seconds = Math.floor((duration / 1000) % 60),
        minutes = Math.floor((duration / (1000 * 60)) % 60),
        hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

        hours = (hours < 10) ? "0" + hours : hours;
        minutes = (minutes < 10) ? "0" + minutes : minutes;
        seconds = (seconds < 10) ? "0" + seconds : seconds;

        return hours + ":" + minutes + ":" + seconds + "." + milliseconds;
    }

    function checkStatus(dates)
    {
        var tampil = 0;
        for (let i = 0; i < dimensi; i++){
            dateDatang = new Date(dataPresent[i]['date']);
            if(dateDatang.getMonth() == dates.getMonth()) {
                if(dateDatang.getDate() == dates.getDate()){
                    if((dataPresent[i]['in'] == 1) && (dataPresent[i]['out'] == 0)){
                        tampil += 1;
                    }
                    if((dataPresent[i]['in'] == 1) && (dataPresent[i]['out'] == 1)){
                        tampil += 1;
                    }
                }
            }
        }
        return tampil;
    }
        
    function getMonth(month,year) {   
        const table = document.getElementById("tableBody");
        if (month == 0) return;
        var date = new Date();
        month -= 1;
        date.setMonth(month, 1);
        date.setYear(year, 1);
        
        var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
        let irow = -1;
        let icol = 0;
        let no = 1;
        var komentar = "";

        var hariEfektif = 0;
        var totalTelat = new Array(3).fill(null);
        var totalPSW = new Array(3).fill(null);

    do {
        let row = table.insertRow(irow);
        //no
        let nomor = row.insertCell(icol);
        nomor.innerHTML = no;
        no += 1; icol += 1;
        //Hari
        let dayName = days[date.getDay()];
        let hari = row.insertCell(icol);
        hari.innerHTML = dayName;
        icol += 1;
        //Tanggal
        let tanggal = row.insertCell(icol);
        tanggal.innerHTML = formatDate(date);
        icol += 1;
        //Jam kerja Datang
        let jamDatang = row.insertCell(icol);
        if (time[0]['shiff'] == 0)
        {
            if((date.getDay()>=1) && (date.getDay()<= 4))
            {
                jamDatang.innerHTML = formatHours(timeIn[0], timeIn[1], timeIn[2]);
                hariEfektif += 1;
            }
            else if(date.getDay()==5)
            {
                jamDatang.innerHTML = formatHours(timeIn[0]-1, timeIn[1]+30, timeIn[2]);
                hariEfektif += 1;
            }
            else 
            {
                jamDatang.innerHTML = " ";
            }
        }
        else
        {
            jamDatang.innerHTML = formatHours(timeIn[0], timeIn[1], timeIn[2]);
            hariEfektif += 1;
        }
        icol += 1;
        //Jam Kerja Pulang
        let jamPulang = row.insertCell(icol);
        if (time[0]['shiff'] == 0)
        {
            if((date.getDay()>=1) && (date.getDay()<= 4))
            {
                jamPulang.innerHTML = formatHours(timeOut[0], timeOut[1], timeOut[2]);
            }
            else if(date.getDay()==5)
            {
                jamPulang.innerHTML = formatHours(timeOut[0]-1, timeOut[1], timeOut[2]);
            }
            else 
            {
                jamPulang.innerHTML = " ";
            }
        }
        else
        {
            jamPulang.innerHTML = formatHours(timeOut[0], timeOut[1], timeOut[2]);
        }
        icol += 1;
        //Datang
        let datang = row.insertCell(icol);
        var dateDatang = new Date();
        var dateTelat = new Date();
        let kondisiDatang = 0;
        let kondisiTelat = "";

        for (let i = 0; i < dimensi; i++){
            dateDatang = new Date(dataPresent[i]['date']);
            if(dateDatang.getMonth() == date.getMonth()) {
                if(dateDatang.getDate() == date.getDate()){
                    if((dataPresent[i]['in'] == 1) && (dataPresent[i]['out'] == 0)){
                        if (time[0]['shiff'] == 0)
                        {
                            if(dateDatang.getHours() != 0)
                            {
                                if((dateDatang.getDay()>=1) && (dateDatang.getDay()<= 4)){
                                    dateTelat.setHours(timeIn[0], timeIn[1], timeIn[2]);
                                    kondisiTelat = formatTelat(dateTelat.getTime() - dateDatang.getTime());
                                    datang.innerHTML = formatClock(dateDatang);
                                    kondisiDatang = 1;
                                }
                                else if(dateDatang.getDay()==5){
                                    dateTelat.setHours(timeIn[0]-1, timeIn[1]+30, timeIn[2]);
                                    kondisiTelat = formatTelat(dateTelat.getTime() - dateDatang.getTime());
                                    datang.innerHTML = formatClock(dateDatang);
                                    kondisiDatang = 1;
                                }
                                else{
                                    kondisiDatang = 2;
                                    datang.innerHTML = " ";
                                }
                            }
                            else
                            {
                                kondisiDatang = 3;
                                komentar = dataPresent[i]['keterangan'];
                            }
                        }
                        else
                        {
                            if(dateDatang.getHours() != 0)
                            {
                                dateTelat.setHours(timeIn[0], timeIn[1], timeIn[2]);
                                kondisiTelat = formatTelat(dateTelat.getTime() - dateDatang.getTime());
                                datang.innerHTML = formatClock(dateDatang);
                                kondisiDatang = 1;
                            }
                            else
                            {
                                kondisiDatang = 3;
                                komentar = dataPresent[i]['keterangan'];
                            }    
                        }
                    }
                }
            }
        }
        icol += 1;
        //Pulang
        let pulang = row.insertCell(icol);
        var datePulang = new Date();
        var datePulangAwal = new Date();
        let kondisiPulang = 0;
        let kondisiPulangAwal = "";

        for (let i = 0; i < dimensi; i++){
            datePulang = new Date(dataPresent[i]['date']);
            if(datePulang.getMonth() == date.getMonth()) {
                if(datePulang.getDate() == date.getDate()){
                    if((dataPresent[i]['in'] == 1) && (dataPresent[i]['out'] == 1)){
                        if (time[0]['shiff'] == 0)
                        {
                            if(datePulang.getHours() != 0)
                            {
                                if((datePulang.getDay()>=1) && (datePulang.getDay()<= 4)){
                                    datePulangAwal.setHours(timeOut[0], timeOut[1], timeOut[2]);
                                    kondisiPulangAwal = formatTelat(datePulangAwal.getTime() - datePulang.getTime());
                                    pulang.innerHTML = formatClock(datePulang);
                                    kondisiPulang = 1;
                                }
                                else if(datePulang.getDay()==5){
                                    datePulangAwal.setHours(timeOut[0]-1, timeOut[1], timeOut[2]);
                                    kondisiPulangAwal = formatTelat(datePulangAwal.getTime() - datePulang.getTime() );
                                    pulang.innerHTML = formatClock(datePulang);
                                    kondisiPulang = 1;
                                }
                                else{
                                    pulang.innerHTML = " ";
                                    kondisiPulang = 2;
                                }
                            }
                            else
                            {
                                kondisiPulang = 3;
                                komentar = dataPresent[i]['keterangan'];
                            }
                        }
                        else
                        {
                            if(datePulang.getHours() != 0)
                            {
                                datePulangAwal.setHours(timeOut[0], timeOut[1], timeOut[2]);
                                kondisiPulangAwal = formatTelat(datePulangAwal.getTime() - datePulang.getTime());
                                pulang.innerHTML = formatClock(datePulang);
                                kondisiPulang = 1;
                            }
                            else
                            {
                                kondisiPulang = 3;
                                komentar = dataPresent[i]['keterangan'];
                            }
                        }
                    }
                }
            }
        }
        icol += 1;
        //keterangan
        let keterangan = row.insertCell(icol);
        var statusKeterangan = 0;
        if (time[0]['shiff'] == 0)
        {
            if ((date.getDay()>=1) && (date.getDay()<= 4)) {
                if ((kondisiDatang == 1) && (kondisiPulang == 1)) {
                    keterangan.innerHTML = "Hadir";
                }
                else if ((kondisiDatang == 2) && (kondisiPulang == 2)){
                    keterangan.innerHTML = " ";
                }
                else if ((kondisiDatang == 3) || (kondisiPulang == 3)){
                    keterangan.innerHTML = komentar;
                    statusKeterangan = 1;
                }
                else{
                    keterangan.innerHTML = " ";
                }
            }
            else if (date.getDay()==5) {
                if ((kondisiDatang == 1) && (kondisiPulang == 1)) {
                    keterangan.innerHTML = "Hadir";
                }
                else if ((kondisiDatang == 2) && (kondisiPulang == 2)){
                    keterangan.innerHTML = " ";
                }
                else if ((kondisiDatang == 3) || (kondisiPulang == 3)){

                    keterangan.innerHTML = komentar;
                    statusKeterangan = 1;
                }
                else{
                    keterangan.innerHTML = " ";
                }
            }
            else if ((date.getDay()==6) || (date.getDay()==0)) {
                keterangan.innerHTML = "Libur";
            }
        }
        else
        {
            if ((kondisiDatang == 1) && (kondisiPulang == 1)) {
                keterangan.innerHTML = "Hadir";
            }
            else if ((kondisiDatang == 3) || (kondisiPulang == 3)){
                keterangan.innerHTML = komentar;
                statusKeterangan = 1;
            }
            else{
                keterangan.innerHTML = " ";
            }
        }
        icol += 1;
        //TL1
        let telat1 = row.insertCell(icol);
        var tl = kondisiTelat.split(":");

        if(statusKeterangan != 1)
        {
            if ((tl[0] == 23) && (tl[1] > 30)) {
                telat1.innerHTML = "1";
                totalTelat[0] += 1;
            }
            else {
                telat1.innerHTML = "0";
            }
        }
        else
        {
            telat1.innerHTML = "0";
        }
        icol += 1;
        //TL2
        let telat2 = row.insertCell(icol);

        if(statusKeterangan != 1)
        {
            if ((tl[0] == 23) && (tl[1] < 30)) {
                telat2.innerHTML = "1";
                totalTelat[1] += 1;
            }
            else {
                telat2.innerHTML = "0";
            }
        }
        else
        {
            telat2.innerHTML = "0";
        }
        icol += 1;
        //Tl3
        let telat3 = row.insertCell(icol);

        if(statusKeterangan != 1)
        {
            if ((tl[0] < 23) && (tl[0] != 00)) {
                telat3.innerHTML = "1";
                totalTelat[2] += 1;
            }
            else {
                telat3.innerHTML = "0";
            }
        }
        else
        {
            telat3.innerHTML = "0";
        }
        icol += 1;
        //PSW1
        let psw1 = row.insertCell(icol);
        var psw = kondisiPulangAwal.split(":");

        if(statusKeterangan != 1)
        {
            if ((psw[0] == 00) && (psw[1] < 30)) {
                psw1.innerHTML = "1";
                totalPSW[0] += 1;
            }
            else {
                psw1.innerHTML = "0";
            }
        }
        else
        {
            psw1.innerHTML = "0";
        }
        icol += 1;
        //PSW2
        let psw2 = row.insertCell(icol);

        if(statusKeterangan != 1)
        {
            if ((psw[0] ==  00) && (psw[1] > 30)) {
                psw2.innerHTML = "1";
                totalPSW[1] += 1;
            }
            else {
                psw2.innerHTML = "0";
            }
        }
        else
        {
            psw2.innerHTML = "0";
        }
        icol += 1;
        //PSW3
        let psw3 = row.insertCell(icol);

        if(statusKeterangan != 1)
        {
            if ((psw[0] >= 01) && (psw[0] < 20)) {
                psw3.innerHTML = "1";
                totalPSW[2] += 1;
            }
            else {
                psw3.innerHTML = "0";
            }
        }  
        else
        {
            psw3.innerHTML = "0";
        }
        icol += 1;
        //setDate Next
        date.setDate(date.getDate()+1);
        icol = 0; kondisiDatang = 0; kondisiPulang = 0;
        }while(date.getMonth() == month);
        getRecap(hariEfektif,totalTelat,totalPSW)
    }

    function getRecap(hariEfektif,totalTelat,totalPSW) {
        const tableRecap = document.getElementById("tableRecap");
        // var uraian = ["Hari "]
        
        //Hari Efektif
        let rowRecap = tableRecap.insertRow(0);
        let hariEfek = rowRecap.insertCell(0);
        hariEfek.innerHTML = "Hari Efektif";
        hariEfek = rowRecap.insertCell(1);
        hariEfek.innerHTML = hariEfektif;
        //TL1
        rowRecap = tableRecap.insertRow(1);
        let tl1Recap = rowRecap.insertCell(0);
        tl1Recap.innerHTML = "TL1";
        tl1Recap = rowRecap.insertCell(1);
        tl1Recap.innerHTML = totalTelat[0];
        //TL2
        rowRecap = tableRecap.insertRow(2);
        let tl2Recap = rowRecap.insertCell(0);
        tl2Recap.innerHTML = "TL2";
        tl2Recap = rowRecap.insertCell(1);
        tl2Recap.innerHTML = totalTelat[1];
        //TL3
        rowRecap = tableRecap.insertRow(3);
        let tl3Recap = rowRecap.insertCell(0);
        tl3Recap.innerHTML = "TL3";
        tl3Recap = rowRecap.insertCell(1);
        tl3Recap.innerHTML = totalTelat[2];
        //PSW1
        rowRecap = tableRecap.insertRow(4);
        let PSW1Recap = rowRecap.insertCell(0);
        PSW1Recap.innerHTML = "PSW1";
        PSW1Recap = rowRecap.insertCell(1);
        PSW1Recap.innerHTML = totalPSW[0];
        //PWS2
        rowRecap = tableRecap.insertRow(5);
        let PSW2Recap = rowRecap.insertCell(0);
        PSW2Recap.innerHTML = "PSW2";
        PSW2Recap = rowRecap.insertCell(1);
        PSW2Recap.innerHTML = totalPSW[1];
        //PSW3
        rowRecap = tableRecap.insertRow(6);
        let PSW3Recap = rowRecap.insertCell(0);
        PSW3Recap.innerHTML = "PSW3";
        PSW3Recap = rowRecap.insertCell(1);
        PSW3Recap.innerHTML = totalPSW[2];
    }
    
    </script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
