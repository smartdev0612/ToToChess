if(typeof(FILTER_JS)=='undefined')
{if(typeof g4_cf_filter=='undefined')
alert('g4_cf_filter 변수가 선언되지 않았습니다. js/filter.js');var FILTER_JS=true;function word_filter_check(v)
{var trim_pattern=/(^\s*)|(\s*$)/g;var filter=g4_cf_filter;var s=filter.split(",");for(i=0;i<s.length;i++)
{s[i]=s[i].replace(trim_pattern,"");if(s[i]=="")continue;if(v.indexOf(s[i])!=-1)
return s[i];}
return"";}}