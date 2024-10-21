// function CountEvenNumbers(start, end){
//     let count = 0;
//     let evenNumbers = [];

//     for (let i = start ;i<= end;i++){
//         if(i % 2 == 0){
//             count++;
//             evenNumbers.push(i);
//         }
//     }
//     console.log(count + " (" + evenNumbers.join(", ") + ")");
//     return count;
// }
// CountEvenNumbers(1,10);




// function hitungDiskon(harga, jenisBarang) {
//     let diskon = 0;

   
//     switch (jenisBarang.toLowerCase()) {
//         case "elektronik":
//             diskon = 10;
//             break;
//         case "pakaian":
//             diskon = 20;
//             break;
//         case "makanan":
//             diskon = 5;
//             break;
//         default:
//             diskon = 0;
//             break;
//     }

   
//     let hargaDiskon = harga - (harga * diskon / 100);
//     console.log("Masukkan Harga Barang : Rp"+ harga);
//     console.log("Masukkan Jenis Barang (Elektronik,Pakaian,Makanan,Lainnya) : " + jenisBarang);

//     console.log('Harga Awal : Rp' + harga);
//     console.log('Diskon : ' + diskon + "%");
//     console.log('Harga Setelah Diskon : Rp'+ hargaDiskon);

//     return hargaDiskon;
// }


// let harga = 10000
// let jenisBarang = "makanan"; 
// let hasil;
// hitungDiskon(harga, jenisBarang);



// function Cari(HariSekarang,JumlahHari){
//     let hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
//     let CariIndex = hari.indexOf(HariSekarang);
//     let IndexHariDicari = ((JumlahHari %7 ) + CariIndex) %7;
//     hasil = IndexHariDicari
//     return hari[IndexHariDicari];
// }
// let HariSekarang = "Minggu";
// let JumlahHari = "1000";

// let HariYangDicari = Cari(HariSekarang,JumlahHari);
// console.log("Hari ini : " + HariSekarang);
// console.log(JumlahHari +" "+ " Hari Yang Akan Datang Adalah : " + HariYangDicari);



function t4() {
    const acak = Math.floor(Math.random()*100)+1;
    let count = 0;
    let tebakan = null;

    while (acak !== tebakan) {
        tebakan = prompt('Masukkan Salah Satu dari Angka 1 Sampai 100 : ');
        tebakan = parseInt(tebakan);
        if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
            alert('INPUTAN TIDAK VALIDD!!!');
            continue 
        }
        count++
        if (tebakan > acak){
            alert("Terlalu tinggi")
        }
        else if (tebakan < acak){
            alert("Terlalu rendah")
        }
        else{
            alert(`Selamat! kamu berhasil menebak angka ${acak} dengan benar.Sebanyak ${count}x percobaan.`);
            
        }
    }
}



