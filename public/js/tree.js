/*!
 * jQuery based plugin - Tree View
 * Author : vsvvssrao (https://github.com/vsvvssrao)
 * Demo link : https://vsvvssrao.github.io/TreeView/
 * Date: Sat Oct 26 2019
 */
(function ($) {
  $.fn.tree = function (userid, options) {
    var settings = $.extend({
      onDemandData: function () { }
    }, options);
    function createTree(userid, ulClassName) {
      var parentUl = document.createElement('ul');
      parentUl.className = ulClassName;
      var ajax_request = $.ajax({
        type: 'POST',  
        url : "/get-referrals",
        data: {id: userid},
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
          success: function(result){
            result = JSON.parse(result);
            result.forEach(element => {
              var liElement = document.createElement('li');
              liElement.setAttribute('data-hasChild', true);
              liElement.setAttribute('data-id', element.id);
              liElement.setAttribute('data-isLoaded', false);
              if (element.hasChild || 1) {
                var spanElement = document.createElement('span');
                spanElement.innerHTML = element.first_name + " (" +element.userid + ")";
                spanElement.className = 'tv-caret';
                spanElement.setAttribute('data-id', element.userid);
                liElement.append(spanElement);
              } else {
                liElement.innerHTML = element.first_name + " (" +element.userid + ")";
              }
              parentUl.append(liElement);
            });
                }
      })
      return parentUl;
    }
    $(this).off('click','.tv-caret').on('click','.tv-caret', function () {
      var $this = $(this);
      var userid = $this.data('id');
      if (!$this.parent('li').data("isloaded")) {
        // fetch data
        var a = createTree(userid, 'tv-nested');
        // Append the data
        $this.parent('li').append(a);
        // Set isloaded to true
        $this.parent('li').data("isloaded",true);
      }
      $this.parent('li').find('.tv-nested').toggleClass("active");
      $this.toggleClass("tv-caret-down");

    })
    return this;
  };
}(jQuery));
