
// NOMOR 2
let harga = prompt("Masukan harga barang: ").trim();
console.log("Masukan harga barang: " + harga);

harga = parseInt(harga); //1

if (isNaN(harga) || harga < 0) {
    console.log("Input harga tidak valid, masukkan angka.");
} else {
    let jenis = prompt("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ").trim().toLowerCase();
    console.log("Jenis barang: " + jenis);
    console.log("Harga awal: Rp" + harga);
    if (jenis === "elektronik") {
        console.log("Diskon: 10%");
        harga = harga - (harga * 0.1);
        console.log("Harga setelah diskon: Rp" + harga);
    } else if (jenis === "pakaian") {
        console.log("Diskon: 20%");
        harga = harga - (harga * 0.2);
        console.log("Harga setelah diskon: Rp" + harga);
    } else if (jenis === "makanan") {
        console.log("Diskon: 5%");
        harga = harga - (harga * 0.05);
        console.log("Harga setelah diskon: Rp" + harga);
    } else {
        console.log("Barang ini tidak didiskon, sehingga harganya: Rp" + harga);
    }
}
