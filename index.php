<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan Alat Kesehatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Pengaduan Alat Kesehatan</h2>
        <form>
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required readonly>

            <label for="nama">Nama Pelapor:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="telepon">No Telepon Pelapor:</label>
            <input type="tel" id="telepon" name="telepon" required>

            <label for="email">Email Pelapor:</label>
            <input type="email" id="email" name="email" required>

            <label for="faskes">Faskes:</label>
            <select id="faskes" name="faskes" required>
                <option value="RS">Rumah Sakit</option>
                <option value="Puskesmas">Puskesmas</option>
                <option value="Lab">Laboratorium</option>
            </select>

            <label for="provinsi">Alamat Provinsi:</label>
            <select id="provinsi" name="provinsi" required>
                <option value="">-- PILIH PROVINSI --</option>
            </select>

            <label for="kota">Kabupaten/Kota:</label>
            <select id="kota" name="kota" required>
                <option value="">-- PILIH KABUPATEN/KOTA --</option>
            </select>

            <label for="telepon_faskes">No Telpon Faskes:</label>
            <input type="tel" id="telepon_faskes" name="telepon_faskes" required>

            <label for="sn_alat">S/N Alat:</label>
            <input type="text" id="sn_alat" name="sn_alat" required>

            <label for="tipe_alat">Tipe Alat:</label>
            <select id="tipe_alat" name="tipe_alat" required>
                <option value="alat1">Tipe 1</option>
                <option value="alat2">Tipe 2</option>
                <option value="alat3">Tipe 3</option>
            </select>

            <label for="keluhan">Keluhan:</label>
            <textarea id="keluhan" name="keluhan" rows="4" required></textarea>

            <label for="foto">Upload Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>

            <button type="submit">Kirim</button>
        </form>
    </div>

    <script>
        // Set tanggal otomatis ke hari ini
        document.getElementById("tanggal").valueAsDate = new Date();

        // Menggunakan API untuk mendapatkan daftar provinsi
        fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
            .then(response => response.json())
            .then(data => {
                let provinsiSelect = document.getElementById("provinsi");
                data.forEach(prov => {
                    let option = document.createElement("option");
                    option.value = prov.id;
                    option.textContent = prov.name;
                    provinsiSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Gagal mengambil data provinsi", error));

        // Mengambil daftar kabupaten/kota berdasarkan provinsi yang dipilih
        document.getElementById("provinsi").addEventListener("change", function() {
            let provinsiId = this.value;
            let kotaSelect = document.getElementById("kota");
            kotaSelect.innerHTML = "<option value=''>-- PILIH KABUPATEN/KOTA --</option>"; // Reset opsi kota
            
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kota => {
                        let option = document.createElement("option");
                        option.value = kota.id;
                        option.textContent = kota.name;
                        kotaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Gagal mengambil data kota", error));
        });
    </script>
</body>
</html>