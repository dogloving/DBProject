//字符串转为数字
function strToNum(s){
	var num = 0;
	for(var i = 0;i < s.length;++i){
		num = num*10+(s[i]-'0');
	}
	return num;
}