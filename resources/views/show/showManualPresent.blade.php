<!-- Extend Tamplate Master -->
@extends('layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Present {{$pinStaff->name}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

    <!-- cotent disini     -->
    <h2 class="text-center" id="judul"></h2>
    <table class="table table-bordered border-dark">
    <head>
        <tr>
            <th class="dateCell" rowspan="2">No</th>
            <th rowspan="2">Hari</th>
            <th rowspan="2">Tanggal</th>
            <th colspan="2">Jam Kerja</th>
            <th colspan="2">Rekaman Presensi</th>
            <th rowspan="2">Keterangan</th>
            <th rowspan="2">Action</th>
        </tr>
        <tr>
            <th>Datang</th>
            <th>Pulang</th>
            <th>Datang</th>
            <th>Pulang</th>
        </tr>
    </head>
    @csrf
    <tbody id="tableBody">
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
        var dataStaff = <?php echo json_encode($pinStaff); ?>;
        var dataPresent = <?php echo json_encode($pinPresent); ?>;
        var time = <?php echo json_encode($time); ?>;
        var dimensi = '<?= $dimensi ?>';

        var timeIn = time[0]['in'].split(":");
        var timeOut = time[0]['out'].split(":");
        
        getMonth(mount,year)

        const bulan = ["Januari", "Februari", "Maret", "April", "Mai", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember"];
        // document.getElementById("judul").innerHTML = "Rekap Daftar Kehadiran kepegawaian Bulan " + bulan[mount];
    
    function formatDate(d) {
        var z = x => ('0'+x).slice(-2);
        return z(d.getDate()) + '-' + z(d.getMonth()+1) + '-' + d.getFullYear();
    }

    function formatDatePHP(d) {
        var z = x => ('0'+x).slice(-2);
        return z(d.getFullYear()) + '-' + z(d.getMonth()+1) + '-' + d.getDate();
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
        //action
        let action = row.insertCell(icol);
        var link = "/showDatePresent/" + dataStaff['pin'] + "/"+ formatDatePHP(date);
        const a = document.createElement('a');
        a.textContent = 'edit';
        a.href = link;
        a.click;
        action.appendChild(a);
        
        icol += 1;
        //setDate Next
        date.setDate(date.getDate()+1);
        icol = 0;
        }while(date.getMonth() == month);
    }
    
    </script>
    </div>
</div>
</div>
<!-- /.container-fluid -->
@endsection