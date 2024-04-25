export function dateGenerator(end) {
    for(var arr=[],dt=new Date(); dt<=new Date(end); dt.setDate(dt.getDate()+1)){
        arr.push(new Date(dt));
    }
    console.log(arr);
}