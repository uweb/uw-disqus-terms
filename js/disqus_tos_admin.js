angular.module('disqusOptions', []).controller('disqusOptionsCtrl', [function(){
  this.showInit = function(val){
    this.show_tos = (val == 'on');
  }.bind(this);
}]);
