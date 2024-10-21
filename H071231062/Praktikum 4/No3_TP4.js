function Cari(HariSekarang,JumlahHari){
    let hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
    let cariIndex = hari.indexOf(HariSekarang);
    let indexHariDicari = ((JumlahHari %7 ) + cariIndex) %7;
    hasil = indexHariDicari
    return hari[indexHariDicari];
}
let HariSekarang = "Sabtu";
let JumlahHari = -1;

let HariYangDicari = Cari(HariSekarang,JumlahHari);
console.log("Hari ini : " + HariSekarang);
console.log(JumlahHari +" "+ " Hari Yang Akan Datang Adalah : " + HariYangDicari);
