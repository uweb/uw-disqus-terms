UW = UW || {
  elements : {},
}

_.extend(UW.elements, {
  disqus : '#disqus_thread'
});

(function() {
  var uw_init = UW.initialize;
  UW.initialize = extended_init; 
  function extended_init ($) {
    uw_init($);
    UW.disqus_terms = _.map( $( UW.elements.disqus ),    function( element ) { return new UW.Disqus_Terms({ el : element }) } )
  }
})();

UW.Disqus_Terms = function(args){
  this.template = '<p id="disqus-terms">' + uw.disqus_tos_text + '</p>';
  this.$disqus_div = $(args.el);
  $(this.template).insertBefore(this.$disqus_div);
}
