function myWindow(i,t,wid,hei) {
  var day= new Date();
  var id = day.getTime();
  //Full screen
  /*
  var w = (window.width);
  var h = (window.height);
  */

  // You can also use the original image height and width as
  var w = wid+55;
  var h = hei+25;
  var params = 'width='+(w-5)+',height='+(h-5)+',scrollbars,resizable';

  var message='<html><head><title>'+i+'</title></head><body><h3 aligh="center">'+
  '<div align="center"><img src="'+i+'" border="0" alt="'+t+'" width="'+wid+'"><br>\
  '+
  '<hr width="100&#37;" size="1"><form><input type="button" onclick="javascript:window.close();" value="ЗАКРЫТЬ"><br>\
  '+
  '<hr width="100%" size="1"></form></div></body></html>\
  ';

  var mywin = open('',id,params);
  mywin.document.write(message);
  mywin.document.close();
}
