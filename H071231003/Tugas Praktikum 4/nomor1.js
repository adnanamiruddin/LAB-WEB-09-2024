function countEvenNumbers (start, end) {
    let hasil = [];
    for (i = start; i <= end; i++) {
        if (i % 2 == 0) {
            hasil.push(i);
        }
    }
    const count = hasil.length;
    console.log(`${count} (${hasil.join(',')})`);
    }
countEvenNumbers(1,10); 