<?php // pages/profile.php ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h3 class="fw-semibold mb-4">Profil Kelompok</h3>
          <p class="fs-5">
            Kelompok ini terdiri dari empat anggota yang berperan dalam perancangan
            Data Warehouse, proses ETL, analisis OLAP, serta penyajian visualisasi data.
          </p>

          <div class="row">

            <!-- Anggota 1 -->
            <div class="col-sm-6 col-md-3 mb-4">
              <div class="card h-100">
                <img src="<?= base_url('assets/images/profile/rio.jpeg') ?>" class="card-img-top" alt="Rio Alghaniy Putra">
                <div class="card-body">
                  <h5 class="card-title">Rio Alghaniy Putra</h5>
                  <p class="mb-1"><strong>NIM:</strong> 22082010012</p>
                  <p class="card-text">
                    <strong>Peran:</strong> UI & Data Visualization<br>
                    Bertanggung jawab dalam perancangan tampilan dashboard,
                    pemilihan jenis visualisasi, serta penyajian hasil analisis data
                    agar mudah dipahami oleh pengguna.
                  </p>
                </div>
              </div>
            </div>

            <!-- Anggota 2 -->
            <div class="col-sm-6 col-md-3 mb-4">
              <div class="card h-100">
                <img src="<?= base_url('assets/images/profile/faiz.jpg') ?>" class="card-img-top" alt="Al-Faiz Azzam Aryaputra">
                <div class="card-body">
                  <h5 class="card-title">Al-Faiz Azzam Aryaputra</h5>
                  <p class="mb-1"><strong>NIM:</strong> 22082010022</p>
                  <p class="card-text">
                    <strong>Peran:</strong> ETL & Data Integration<br>
                    Bertugas mengelola proses Extract, Transform, dan Load (ETL)
                    dari database sumber ke Data Warehouse agar data siap dianalisis.
                  </p>
                </div>
              </div>
            </div>

            <!-- Anggota 3 -->
            <div class="col-sm-6 col-md-3 mb-4">
              <div class="card h-100">
                <img src="<?= base_url('assets/images/profile/adam.jpeg') ?>" class="card-img-top" alt="Adam Idhofi Rakasiwi">
                <div class="card-body">
                  <h5 class="card-title">Adam Idhofi Rakasiwi</h5>
                  <p class="mb-1"><strong>NIM:</strong> 22082010026</p>
                  <p class="card-text">
                    <strong>Peran:</strong> Data Analyst & OLAP Query<br>
                    Melakukan analisis data menggunakan OLAP,
                    menyusun query multidimensi, serta menginterpretasikan
                    hasil analisis untuk menjawab kebutuhan bisnis.
                  </p>
                </div>
              </div>
            </div>

            <!-- Anggota 4 -->
            <div class="col-sm-6 col-md-3 mb-4">
              <div class="card h-100">
                <img src="<?= base_url('assets/images/profile/zheand.jpeg') ?>" class="card-img-top" alt="Zheand Rizky Pranasyach">
                <div class="card-body">
                  <h5 class="card-title">Zheand Rizky Pranasyach</h5>
                  <p class="mb-1"><strong>NIM:</strong> 22082010051</p>
                  <p class="card-text">
                    <strong>Peran:</strong> Backend & System Integration<br>
                    Mengimplementasikan Data Warehouse dan OLAP ke dalam aplikasi web,
                    serta mengintegrasikan query Mondrian dengan antarmuka sistem.
                  </p>
                </div>
              </div>
            </div>

          </div><!-- row -->

        </div>
      </div>
    </div>
  </div>
</div>
