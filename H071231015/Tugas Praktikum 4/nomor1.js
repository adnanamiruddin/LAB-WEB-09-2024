
//NOMOR 1

function countEvenNumber(start, end) {// 1 , 10
    let count = 0; // 5
    let result = "(";
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            result += i + ", "; // (2,4,6,8,10, 
            count++;
        }
    }
    result = result.slice(0, -2); // (2, 4, 6, 8, 10
    result += ")"; // (2, 4, 6, 8, 10)
    return `${count}${result}`; // 5(2, 4, 6, 8, 10)
}

console.log(countEvenNumber(1, 10));

