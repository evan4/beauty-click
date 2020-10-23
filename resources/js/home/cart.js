export const removeUtemFromTable = (res, index) => {

  const { cart, cartTemplate } = res;
  
  if (cart['cart-sum'] > 0) {
      const $list = $('.total-list');

      $('.timetable_sub tbody tr').eq(index)
          .fadeOut('slow').remove();

      $list.find('li')
          .last().find('span').text(cart['cart-sum']);

      $list.find('li').eq(index)
          .fadeOut('slow').remove()

      $('.overlay').fadeOut();
  } else {
      $('.checkout-right').fadeOut();
      $('.checkout-left').fadeOut();
      $('.privacy.about').append(cartTemplate)
  }
}

export const updateCartDialog = (cart) => {
  const {services, total, quantity} = cart;

  const $modal = $('#cart');
  let template = '';

  if(services){
    const body = Object.keys(services).map(function(key){
        return [
          `
            <tr>
              <td>
                  <img src="/images/${services[key]['img'] ? services[key]['img'] : 'no_image.png' }" 
                  alt="${services[key]['title']}" height="50">
              </td>
              <td>${services[key]['title']}</td>
              <td>${services[key]['quantity']}</td>
              <td>${services[key]['price']}</td>
              <td>
                  <a href="#" data-id="${services[key]['id']}" class="del-item">
                      <i class="fas fa-trash-alt text-danger"></i>
                  </a>
              </td>
            </tr>`
        ]
    });

    template = `
      ${body}
          <tr>
            <td colspan="4">Итого: </td>
          <td id="cart-qty">${quantity}</td>
          </tr>
          <tr>
            <td colspan="4">На сумму: </td>
            <td id="cart-sum">${total}</td>
          </tr>
    `;
    $modal.find('.modal-body tbody').html(template);
  }else {
    template = '<p>Корзина пуста</p>';
    $modal.find('.modal-body').html(template);
  }

  const $sum = $('#cart-sum').text();
  const $cartSum = total ? total : '$0';

  $('.cart-sum').text($cartSum);
}

export const deleteItem = (id) => {
  return new Promise((resolve, reject) => {

      $.ajax({
          url: 'cart/remove',
          data: { id }
      })
          .done(function (res) {
              if (!res) alert('Произошла ошибка. Попробуйте еще раз');

              updateCartDialog(res.service);
              resolve(res)
          })
          .fail(function (error) {
              reject(error)
          });
  });
}

function changeCartQuantity(id, qty, index) {

  return new Promise((resolve, reject) => {

      $.ajax({
          url: 'cart/change',
          data: { id, qty }
      })
          .done(function (res) {
              if (!res) alert('Произошла ошибка. Попробуйте еще раз');

              const { cart, cartTemplate, product } = res;

              const sum = product.price * product.qty;
              const $list = $('.total-list');
              $list.find('li').eq(index).find('span').text(`$${sum}`)

              // total sum
              $list.find('li')
                  .last().find('span').text(`$${cart['cart-sum']}`);

              updateCartDialog(cartTemplate);

              resolve(cart)
          })
          .fail(function (error) {
              reject(error)
          });
  });
}
