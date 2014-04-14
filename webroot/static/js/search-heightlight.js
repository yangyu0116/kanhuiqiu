/**
 * Created by leexiaosi on 14-4-14.
 */

(function($){
    $.searchHighlight = function(pucl,keyword){
        if("" == keyword) return;
        var temp=pucl.innerHTML;
        var htmlReg = new RegExp("\<.*?\>","i");
        var arrA = new Array();
        //替换HTML标签
        for(var i=0;true;i++)
        {
            var m=htmlReg.exec(temp);
            if(m)
            {
                arrA[i]=m;
            }
            else
            {
                break;
            }
            temp=temp.replace(m,"{[("+i+")]}");
        }
        words = unescape(keyword.replace(/\+/g,' ')).split(/\s+/);
        //替换关键字
        for (w=0;w<words.length;w++)
        {
            var r = new RegExp("("+words[w].replace(/[(){}.+*?^$|\\\[\]]/g, "\\$&")+")","ig");
            temp = temp.replace(r,"<b style='color:Red;'>$1</b>");
        }
        //恢复HTML标签
        for(var i=0;i<arrA.length;i++)
        {
            temp=temp.replace("{[("+i+")]}",arrA[i]);
        }
        pucl.innerHTML=temp;
    };
    $.fn.searchHighlight = function(keyword){
       if(!keyword) return;
       $(this).each(function(index,item){
           $.searchHighlight(item,keyword);
       });
    }
})(jQuery);