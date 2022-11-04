<?php 
    $allowed_inventory = array($list_users["Admin"], $list_users["Inventory"]);
    $allowed_asset = array($list_users["Admin"], $list_users["Inventory"]);
    $allowed_presensi = array($list_users["Admin"], $list_users["Presensi"]);
    $allowed_database = array($list_users["Admin"], $list_users["Bidang Lainnya"]);
    $admin = array($list_users["Admin"]);
?>
<!-- sidebar menu area start -->
<div class="sidebar-menu">
    <div class="sidebar-header">
    <?php 
        if($header == "Admin")
        {
    ?>
            <a href="/"><img src="/Admin.png" alt="logo" width="100%"></a>
    <?php
        }
        else if($header == "Usulan")
        {
    ?>
            <a href="/"><img src="/Usulan.png" alt="logo" width="100%"></a>
    <?php
        }
        else if($header == "Database")
        {
    ?>
            <a href="/"><img src="/Database.png" alt="logo" width="100%"></a>
    <?php
        }
        else
        {
    ?>
            <a href="/"><img src="/Inventory-dinas.png" alt="logo" width="100%"></a>
    <?php
        }
    ?>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <?php
                        if(in_array($current_user, $admin))
                        {
                    ?>
                            <li <?php if($header == "Admin" && false) echo "class=\"active\"" ?>><a href="/users"><strong><i class="ti-user"></i><span>User Settings</strong></span></a></li>
                            <!-- <li><a href="/upload"><i class="ti-cloud-up"></i><span>Usulan Data per Bidang</span></a></li> -->
                    <?php
                        }
                        if(in_array($current_user, $allowed_inventory))
                        {
                    ?>
                            <li><a href="/notes"><i class="ti-clipboard"></i><span>Notes</span></a></li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="false"><i class="ti-folder"></i><span>Persediaan Barang
                                    </span></a>
                                <ul>
                                    <li><a href="/stock"><i class="ti-files"></i><span>Stok Barang</span></a></li>
                                    <li><a hidden href="/stock_alt"><i class="ti-files"></i><span>Stok Barang (beta version)</span></a></li>
                                    <li><a hidden href="/stock/masuk"><i class="ti-import"></i><span>Barang Masuk / Kembali</span></a></li>
                                    <li><a href="/stock/keluar"><i class="ti-share"></i><span>Barang Keluar</span></a></li>
                                </ul>
                            </li>
                    <?php 
                        }
                        if(in_array($current_user, $allowed_asset))
                        {
                    ?>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-package"></i><span>Pendataan Asset
                                    </span></a>
                                <ul>
                                    <li><a href="/asset"><i class="ti-printer"></i><span>Data Barang</span></a></li>
                                    <li><a hidden href="/asset/masuk"><i class="ti-import"></i><span>Pengembalian</span></a></li>
                                    <li><a href="/asset/keluar"><i class="ti-export"></i><span>Peminjaman</span></a></li>
                                </ul>
                            </li>
                    <?php
                        }
                        if(in_array($current_user, $admin) || (in_array($current_user, $allowed_database) && $header == "Upload"))
                        {
                    ?>
                            <!-- <li><a href="/database"><i class="ti-briefcase"></i><span>Database DISPANGTAN</span></a></li> -->
                            <li><a href="/upload"><i class="ti-comments"></i><span>Usulan Data per Bidang</span></a></li>
                    <?php
                        }
                        if(in_array($current_user, $admin) || (in_array($current_user, $allowed_database) && $header == "Database"))
                        {
                    ?>
                            <li><a href="/database"><i class="ti-briefcase"></i><span>Database DISPANGTAN</span></a></li>
                            <!-- <li><a href="/upload"><i class="ti-cloud-up"></i><span>Usulan Data per Bidang</span></a></li> -->
                    <?php
                        }
                        if(in_array($current_user, $allowed_presensi))
                        {
                    ?>
                            <li><a href="/staff"><i class="ti-bookmark-alt"></i><span>Rekap Presensi</span></a></li>
                    <?php
                        }
                    ?>
                    
                    <!-- <li>
                        <a hidden href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Custom
                            </span></a>
                        <ul class="collapse">
                            <li><a href="/stock"><i class="ti-files"></i><span>Stok Barang</span></a></li>
                            <li><a hidden href="/stock/masuk"><i class="ti-import"></i><span>Barang Masuk / Kembali</span></a></li>
                            <li><a href="/stock/keluar"><i class="ti-export"></i><span>Barang Keluar</span></a></li>
                        </ul>
                        <ul class="collapse">
                            
                        </ul>
                    </li> -->
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->