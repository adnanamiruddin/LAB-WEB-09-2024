

//NOMOR 3

const namaHari = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"]; 
const dayAdd = 1000 % 7;



let hari = prompt("Masukkan nama hari: ").trim().toLowerCase(); // senin
console.log("Masukkan nama hari: " + hari);


if (namaHari.includes(hari)) {
    let daycount = 0; // 1
    for (let i = 0; i < namaHari.length; i++) {
        if (namaHari[i] === hari) {
            daycount = i;
            break;
        }
    } 
    daycount = (daycount + dayAdd) % 7; // (1 + 6 ) % 7 = 0
    console.log("Hari ini adalah hari " + namaHari[daycount]);
} else {
    console.log("Hari yang kamu masukkan tidak valid.");
}


