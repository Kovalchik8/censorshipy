
class CensorshipyAjax {
  constructor() {
    this.events();
  }

  events() {
    console.log('msg from ajax');
  }

}

$(function() {
  var censorshipyAjax = new CensorshipyAjax();
})