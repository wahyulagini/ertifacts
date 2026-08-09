<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TokohPenting;

class TokohSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Gajah Mada', 'Patih Majapahit', 'Mahapatih', 'Abad ke-14 M', 'Jawa Timur', 'Pengucap Sumpah Palapa.'],
            ['Hayam Wuruk', 'Raja Terbesar Majapahit', 'Maharaja', 'Abad ke-14 M', 'Jawa Timur', 'Membawa Majapahit ke masa keemasan.'],
            ['Raden Patah', 'Pendiri Demak', 'Sultan Demak', 'Abad ke-15 M', 'Jawa Tengah', 'Pendiri kesultanan Islam pertama di Jawa.'],
            ['Sultan Agung', 'Raja Mataram', 'Sultan', 'Abad ke-17 M', 'Yogyakarta', 'Melawan VOC di Batavia.'],
            ['Pangeran Diponegoro', 'Pemimpin Perang Jawa', 'Pangeran', 'Abad ke-19 M', 'Yogyakarta', 'Memimpin Perang Diponegoro (1825-1830).'],
            ['Tuanku Imam Bonjol', 'Pemimpin Perang Padri', 'Ulama', 'Abad ke-19 M', 'Sumatera Barat', 'Memimpin kaum Padri di Minangkabau.'],
            ['Cut Nyak Dhien', 'Pahlawan Wanita Aceh', 'Srikandi', 'Abad ke-19 M', 'Aceh', 'Berjuang melawan kolonial Belanda di Aceh.'],
            ['R.A. Kartini', 'Pahlawan Emansipasi', 'Raden Ajeng', 'Akhir Abad ke-19 M', 'Jepara', 'Pelopor kebangkitan perempuan pribumi.'],
            ['Soekarno', 'Bapak Proklamator', 'Presiden Pertama', 'Abad ke-20 M', 'Jawa Timur', 'Bapak Proklamator kemerdekaan RI.'],
            ['Mohammad Hatta', 'Bapak Koperasi', 'Wakil Presiden Pertama', 'Abad ke-20 M', 'Sumatera Barat', 'Proklamator dan perancang ekonomi kerakyatan.'],
            ['Ki Hajar Dewantara', 'Bapak Pendidikan', 'Raden Mas', 'Abad ke-20 M', 'Yogyakarta', 'Pendiri Taman Siswa.'],
            ['Mulawarman', 'Raja Kutai', 'Maharaja', 'Abad ke-4 M', 'Kalimantan Timur', 'Raja terkenal dari Kerajaan Kutai.'],
            ['Purnawarman', 'Raja Tarumanegara', 'Maharaja', 'Abad ke-5 M', 'Jawa Barat', 'Raja yang membangun saluran Gomati.'],
            ['Kertanegara', 'Raja Singhasari', 'Maharaja', 'Abad ke-13 M', 'Jawa Timur', 'Pelopor ekspedisi Pamalayu.'],
            ['Tribhuwana Tunggadewi', 'Ratu Majapahit', 'Maharani', 'Abad ke-14 M', 'Jawa Timur', 'Ratu penakluk Nusantara bersama Gajah Mada.'],
            ['Sisingamangaraja XII', 'Raja Batak', 'Raja', 'Abad ke-19 M', 'Sumatera Utara', 'Pahlawan nasional dari tanah Batak.'],
            ['Pattimura', 'Pahlawan Maluku', 'Kapitan', 'Abad ke-19 M', 'Maluku', 'Memimpin pemberontakan melawan Belanda di Saparua.'],
            ['Sultan Hasanuddin', 'Ayam Jantan dari Timur', 'Sultan Gowa', 'Abad ke-17 M', 'Makassar', 'Pemimpin perlawanan VOC di Sulawesi Selatan.'],
            ['I Gusti Ngurah Rai', 'Pahlawan Bali', 'Kolonel', 'Abad ke-20 M', 'Bali', 'Pemimpin perang Puputan Margarana.'],
            ['Cut Meutia', 'Srikandi Aceh', 'Pejuang', 'Abad ke-20 M', 'Aceh', 'Melanjutkan gerilya melawan Belanda.'],
            ['Martha Christina Tiahahu', 'Srikandi Maluku', 'Pejuang', 'Abad ke-19 M', 'Maluku', 'Gadis pemberani yang melawan Belanda bersama ayahnya.'],
            ['Jenderal Sudirman', 'Bapak TNI', 'Panglima Besar', 'Abad ke-20 M', 'Purbalingga', 'Panglima besar TKR, memimpin gerilya dengan tandu.'],
            ['Tjut Nyak Meutia', 'Pahlawan Aceh', 'Srikandi', 'Abad ke-19 M', 'Aceh', 'Berperang di garis depan.'],
            ['Sultan Nuku', 'Lord of Fortune', 'Sultan Tidore', 'Abad ke-18 M', 'Tidore', 'Tidak pernah kalah melawan Belanda.'],
            ['Sultan Baabullah', 'Penguasa 72 Pulau', 'Sultan Ternate', 'Abad ke-16 M', 'Ternate', 'Mengusir Portugis dari Ternate.'],
            ['Raden Wijaya', 'Pendiri Majapahit', 'Sri Kertarajasa', 'Abad ke-13 M', 'Jawa Timur', 'Raja pertama Majapahit.'],
            ['Ken Arok', 'Pendiri Singhasari', 'Rajasa', 'Abad ke-13 M', 'Jawa Timur', 'Tokoh cikal bakal raja-raja Jawa.'],
            ['Teuku Umar', 'Pahlawan Aceh', 'Johan Pahlawan', 'Abad ke-19 M', 'Aceh', 'Ahli taktik perang Aceh.'],
            ['Sam Ratulangi', 'Pahlawan Minahasa', 'Gubernur Sulawesi', 'Abad ke-20 M', 'Sulawesi Utara', 'Tokoh pendidikan dan kemerdekaan.'],
            ['Frans Kaisiepo', 'Pahlawan Papua', 'Gubernur Papua', 'Abad ke-20 M', 'Papua', 'Pengusul nama Irian.'],
            ['Sultan Syarif Kasim II', 'Sultan Siak', 'Sultan', 'Abad ke-20 M', 'Riau', 'Menyumbangkan harta untuk Republik Indonesia.'],
            ['Nyi Ageng Serang', 'Panglima Wanita', 'Raden Ayu', 'Abad ke-19 M', 'Jawa Tengah', 'Ahli taktik militer Perang Diponegoro.'],
            ['Sultan Mahmud Badaruddin II', 'Sultan Palembang', 'Sultan', 'Abad ke-19 M', 'Palembang', 'Melawan Inggris dan Belanda.'],
            ['Aria Wangsakara', 'Pendiri Tangerang', 'Raden', 'Abad ke-17 M', 'Banten', 'Ulama penyebar Islam dan pejuang Banten.'],
            ['Depati Amir', 'Pahlawan Bangka', 'Pahlawan', 'Abad ke-19 M', 'Bangka Belitung', 'Melawan monopoli timah Belanda.']
        ];

        foreach ($data as $item) {
            TokohPenting::updateOrCreate(
                ['nama_tokoh' => $item[0]],
                [
                    'nama_julukan' => $item[1],
                    'gelar' => $item[2],
                    'era_aktif' => $item[3],
                    'tempat_asal' => $item[4],
                    'biografi' => $item[5],
                    'kontribusi' => $item[5],
                    'gambar_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80'
                ]
            );
        }
    }
}
