function CountEvenNumbers(start, end){
    let count = 0;
    let evenNumbers = [];

    for (let i = start ;i<= end;i++){
        if(i % 2 == 0){
            count++;
            evenNumbers.push(i);
        }
    }
    console.log(count + " (" + evenNumbers.join(", ") + ")");
    return count;
}
CountEvenNumbers(1,10);
