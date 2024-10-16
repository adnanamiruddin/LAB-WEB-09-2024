


// NOMOR 4

const secret = Math.floor(Math.random() * 100) + 1;
// math random = 0.81 = 9.8= 10 
// console.log("Real number: " + secret);
let count = 0;

while (true) {
    count++;
    let guess = parseInt(prompt("Masukkan salah satu dari angka 1 sampai 100: ").trim());
    console.log("Masukkan salah satu dari angka 1 sampai 100: " + guess);

    if (isNaN(guess) || guess <= 1 || guess >= 100) {
        console.log("Input tidak valid, masukkan angka antara 1 dan 100.");
        continue;
    } else {
        if (guess === secret) {
            console.log("Selamat! kamu berhasil menebak angka " + guess + " dengan benar.");
            console.log("Sebanyak " + count + "x kali");
            break;
        } else if (guess < secret) {
            console.log("Terlalu rendah! Coba lagi.");
        } else {
            console.log("Terlalu tinggi! Coba lagi.");
        }
    }
}
