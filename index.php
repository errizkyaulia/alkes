<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan Alat Kesehatan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Form Pengaduan Alat Kesehatan</h2>
        <form>
            <div class="step active" id="step1">
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" required readonly>

                <h3>Data Pelapor</h3>
                <label for="nama">Nama Pelapor:</label>
                <input type="text" id="nama" name="nama" required>

                <label for="telepon">No Telepon Pelapor:</label>
                <input type="tel" id="telepon" name="telepon" required>

                <label for="email">Email Pelapor:</label>
                <input type="email" id="email" name="email" required>

                <div class="buttons">
                    <button type="button" onclick="validateAndNext(1)">Selanjutnya</button>
                </div>
            </div>

            <div class="step" id="step2">
                <h3>Data Faskes</h3>
                <label for="faskes">Faskes:</label>
                <select id="faskes" name="faskes" required>
                    <option value="RS">Rumah Sakit</option>
                    <option value="Puskesmas">Puskesmas</option>
                    <option value="Lab">Laboratorium</option>
                </select>

                <label for="nama_faskes">Nama Faskes - Kode Faskes:</label>
                <input type="text" id="nama_faskes" name="nama_faskes" required>

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

                <div class="buttons">
                    <button type="button" onclick="prevStep(2)">Kembali</button>
                    <button type="button" onclick="validateAndNext(2)">Selanjutnya</button>
                </div>
            </div>

            <div class="step" id="step3">
                <h3>Data Keluhan Alat</h3>
                <label for="nama_alat">Nama Alat:</label>
                <input type="text" id="nama_alat" name="nama_alat" required>

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
                <input type="file" id="foto" name="foto" accept="image/*" required>`

                <div class="buttons">
                    <button type="button" onclick="prevStep(3)">Kembali</button>
                    <button type="button" onclick="validateAndNext(3)">Selanjutnya</button>
                </div>
            </div>

            <div class="step" id="step4">
                <h3>Preview Data Keluhan</h3>
                <p id="previewData"></p>

                <div class="buttons">
                    <button type="button" onclick="prevStep(4)">Kembali</button>
                    <button type="submit">Kirim</button>
                </div>
            </div>

        </form>
    </div>


    <script>
        function validateAndNext(currentStep) {
            let inputs = document.querySelectorAll(`#step${currentStep} input, #step${currentStep} select, #step${currentStep} textarea`);
            for (let input of inputs) {
                if (!input.value) {
                    alert("Harap lengkapi semua data sebelum melanjutkan.");
                    return;
                }
            }
            nextStep(currentStep);
        }

        function nextStep(step) {
            document.getElementById(`step${step}`).classList.remove("active");
            document.getElementById(`step${step + 1}`).classList.add("active");

            if(step === 3) {
                let previewData = document.getElementById("previewData");
                let form = document.querySelector("form");
                let formData = new FormData(form);

                let data = "";
                for(let pair of formData.entries()) {
                    data += `${pair[0]}: ${pair[1]}\n`;
                }

                previewData.textContent = data;
            }
        }

        function prevStep(step) {
            document.getElementById(`step${step}`).classList.remove("active");
            document.getElementById(`step${step - 1}`).classList.add("active");
        }
    </script>
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