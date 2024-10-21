
function hitungDiskon(harga, jenisBarang) {
    let diskon = 0;

   
    switch (jenisBarang.toLowerCase()) {
        case "elektronik":
            diskon = 10;
            break;
        case "pakaian":
            diskon = 20;
            break;
        case "makanan":
            diskon = 5;
            break;
        default:
            diskon = 0;
            break;
    }

   
    let hargaDiskon = harga - (harga * diskon / 100);

    console.log(`Masukkan Harga Barang : Rp${harga}`);
    console.log("Masukkan Jenis Barang (Elektronik,Pakaian,Makanan,Lainnya) : " + jenisBarang);

    console.log('Harga Awal : Rp' + harga);
    console.log('Diskon : ' + diskon + "%");
    console.log('Harga Setelah Diskon : Rp'+ hargaDiskon);

    return hargaDiskon;
}


let harga = 100000
let jenisBarang = "pakaian"; 
let hasil;
hitungDiskon(harga, jenisBarang);
