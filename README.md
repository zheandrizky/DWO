# Data Warehouse Penjualan AdventureWorks 2008 (Star Schema)

## Deskripsi Umum
Repositori ini berisi perancangan dan implementasi **Data Warehouse (DW)** menggunakan pendekatan **Star Schema** yang dibangun berdasarkan basis data **AdventureWorks 2008**. Data warehouse ini dirancang untuk mendukung kebutuhan analisis penjualan (Decision Support System / OLAP) dengan fokus pada efisiensi struktur, kemudahan analisis, serta penghematan sumber daya, sesuai dengan kebutuhan evaluasi akademik (UAS).

Perancangan dilakukan dengan memanfaatkan tabel transaksi utama pada AdventureWorks, yaitu **SalesOrderHeader** dan **SalesOrderDetail**, yang kemudian ditransformasikan ke dalam satu tabel fakta dan beberapa tabel dimensi.

---

## Tujuan
Tujuan utama pembangunan data warehouse ini adalah:
1. Menyediakan struktur data analitis yang terpisah dari sistem operasional (OLTP).
2. Mendukung analisis penjualan berbasis waktu, produk, pelanggan, dan wilayah.
3. Menjawab kebutuhan visualisasi data berupa grafik dan ringkasan penjualan.
4. Menerapkan konsep **Star Schema** secara sederhana namun efektif.

---

## Lingkup Analisis
Data warehouse ini dirancang untuk menjawab lima pertanyaan analisis utama, yaitu:
1. Tren revenue per tahun (line chart)
2. Pertumbuhan penjualan per tahun (trend line chart, persentase)
3. Kontribusi kategori produk terhadap total revenue (pie chart)
4. Identifikasi produk dengan revenue tertinggi dan terendah (bar chart)
5. Penjualan berdasarkan cabang atau wilayah (bar chart)

---

## Sumber Data
Sumber data berasal dari database:
- **AdventureWorks 2008**
- Skema utama yang digunakan:
  - `Sales.SalesOrderHeader`
  - `Sales.SalesOrderDetail`
  - `Production.Product`
  - `Production.ProductSubcategory`
  - `Production.ProductCategory`
  - `Sales.Customer`
  - `Person.Contact`
  - `Sales.SalesTerritory`

---

## Arsitektur Data Warehouse
Data warehouse menggunakan pendekatan **Star Schema** yang terdiri dari satu tabel fakta dan beberapa tabel dimensi.

### 1. Tabel Fakta
**fact_sales**

Tabel ini menyimpan data transaksi penjualan yang telah diringkas (measure) dan menjadi pusat analisis.

| Kolom | Deskripsi |
|------|----------|
| id_sales | Primary key tabel fakta |
| id_product | Foreign key ke dimensi produk |
| id_date | Foreign key ke dimensi waktu |
| id_customer | Foreign key ke dimensi pelanggan |
| id_region | Foreign key ke dimensi wilayah |
| total_revenue | Total nilai penjualan (LineTotal) |

Sumber utama data berasal dari:
- `SalesOrderHeader`
- `SalesOrderDetail`

---

### 2. Tabel Dimensi

#### a. Dimensi Produk (`product`)
Digunakan untuk analisis penjualan berdasarkan produk, kategori, dan subkategori.

| Kolom | Deskripsi |
|------|----------|
| id_product | Primary key |
| product_name | Nama produk |
| product_category | Kategori produk |
| product_subcategory | Subkategori produk |

---

#### b. Dimensi Waktu (`date`)
Digunakan untuk analisis berbasis waktu seperti tren dan pertumbuhan penjualan.

| Kolom | Deskripsi |
|------|----------|
| id_date | Primary key |
| day | Hari |
| month | Bulan |
| quarter | Kuartal |
| year | Tahun |

Tipe data yang digunakan untuk kolom tanggal bersumber dari `OrderDate` pada `SalesOrderHeader`.

---

#### c. Dimensi Pelanggan (`customer`)
Digunakan untuk analisis berdasarkan pelanggan individual.

| Kolom | Deskripsi |
|------|----------|
| id_customer | Primary key |
| customer_name | Nama pelanggan |

Catatan:
- Dimensi ini difokuskan pada **individual customer**, bukan toko (store).
- Nama pelanggan diambil dari tabel `Contact`.

---

#### d. Dimensi Wilayah (`region`)
Digunakan untuk analisis penjualan berdasarkan wilayah atau cabang.

| Kolom | Deskripsi |
|------|----------|
| id_region | Primary key |
| region_name | Nama wilayah |
| country_name | Nama negara |

Sumber data berasal dari tabel `SalesTerritory`.

---

## Proses ETL (Extract, Transform, Load)

### Extract
Data diekstraksi dari database AdventureWorks 2008 tanpa mengubah struktur sumber.

### Transform
Proses transformasi meliputi:
- Pemilihan kolom yang relevan
- Penggabungan tabel header dan detail
- Perhitungan total revenue menggunakan `LineTotal`
- Normalisasi data ke dalam tabel dimensi

### Load
Data dimuat ke database data warehouse (`aw2008`) menggunakan perintah `INSERT INTO db.table` tanpa perintah `USE`.

---

## Catatan Akademik
- Desain dibuat **minimalis** untuk efisiensi dan kemudahan evaluasi.
- Tidak seluruh atribut AdventureWorks digunakan, hanya atribut yang relevan dengan analisis.
- Perhitungan pertumbuhan penjualan dilakukan pada **layer analitik (query/BI tools)**, bukan disimpan langsung di tabel fakta.
- Pendekatan ini sesuai dengan prinsip OLAP dan Data Warehouse klasik.

---

## Tools & Teknologi
- Database: MySQL
- Sumber Data: AdventureWorks 2008
- Metodologi: Star Schema
- Output: Dashboard / Visualisasi OLAP

---

## Penutup
Repositori ini diharapkan dapat menjadi contoh implementasi data warehouse sederhana berbasis Star Schema yang sesuai dengan kebutuhan akademik, serta dapat digunakan sebagai dasar pengembangan analisis bisnis dan visualisasi data di tahap selanjutnya.
