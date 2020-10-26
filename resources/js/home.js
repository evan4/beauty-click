import { updateCartDialog, changeCartQuantity, removeUtemFromTable, deleteItem } from './home/cart';

jQuery(document).ready(function ($) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#cart').find('.modal-body').on('click', '.del-item', function () {
      var id = +$(this).data('id');
      var index = +$(this).closest('tr').index();
  
      if (id > 0) {
        deleteItem(id).then(function (res) {
          if ($('.cart-table').length) {
            console.log(res);
            removeUtemFromTable(res, index);
          }
        });
      }
    });

    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        if (id > 0) {

            $.ajax({
                url: '/cart/add',
                dataType: "json",
                cache: false,
                data: { id }
            })
                .done(function (res) {
                    if (!res) alert('Произошла ошибка. Попробуйте еще раз');

                    const $modal = $('#cart');
                    $modal.modal();

                    updateCartDialog(res.service);

                })
                .fail(function (error) {
                    let res = {
                        'error': 'Произошла ошибка. Попробуйте еще раз'
                    }
                    console.log(res);
                });
        }
    });

    $('.removeItem').on('click', function(e){
        e.preventDefault();
        
        const $tr = $(this).closest("tr");
        
        const id = +$(this).data('id');
        const index = $tr.index();
        console.log(id);

        if(id > 0) {
            $('.overlay').fadeIn();

            deleteItem(id)
            .then(res => {
                
                removeUtemFromTable(res.service, index);
            })
            .catch(error => {
                console.log(error)
                $('.overlay').fadeOut();
            })
        }
    });

    $('.value-plus, .value-minus').on('click', function(){
        const $tr = $(this).closest("tr");
        
        const index = +$tr.index();
        
        const id = +$tr.data('id');
        const curent_price = $(this).siblings('.value');
        
        const value = $(this).hasClass('value-plus') ? 1 : -1;
        
        const newVal = +curent_price.text() + value;
        
        if(newVal>0) {
            changeCartQuantity(id, value, index)
            .then(data => {
                curent_price.text(newVal);
            })
        }
        
    });

    $('#clearCart').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/cart/clear'
        })
            .done(function (res) {
                updateCartDialog('');

                if ($('.cart-table').length) {
                    removeUtemFromTable( res )
                }
            })
            .fail(function (error) {
                let res = {
                    'error': 'Произошла ошибка. Попробуйте еще раз'
                }
                console.log(res);
            });
    });

});
