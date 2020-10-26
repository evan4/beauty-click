export const removeUtemFromTable = (cart, index) => {

  const { total, quantity } = cart;

  if (total > 0) {

    $('.total-list tbody tr').eq(index)
      .fadeOut('slow').remove();

    $('#cart-total').text(total);
    $('#cart-quantity').text(quantity);

    $('.overlay').fadeOut();
  } else {

    $('.order').html('<p>Корзина пуста</p>');
  }
}

export const updateCartDialog = (cart) => {
  const { services, total, quantity } = cart;

  const $modal = $('#cart');
  let template = '';

  if (services && Object.keys(services).length > 0) {
    const body = Object.keys(services).map(function (key) {
      return [
        `
            <tr>
              <td>
                  <img src="/images/${services[key]['img'] ? services[key]['img'] : 'no_image.png'}" 
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

    if ($modal.find('.modal-body tbody').length) {
      $modal.find('.modal-body tbody').html(template);
    } else {
      template = `
      <div class="table-responsive">
       <table class="table table-hover table-striped">
          <thead>
          <tr>
              <th>Фото</th>
              <th>Наименование</th>
              <th>Кол-во</th>
              <th>Цена</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          ${template}
          </tbody>
        </table>
      </div>
      `;
      $modal.find('.modal-body').html(template);
    }

  } else {

    template = '<p>Корзина пуста</p>';
    $modal.find('.modal-body').html(template);
  }

  const $cartSum = total ? total : '$0';

  $('.cart-sum').text($cartSum);
}

export const deleteItem = (id) => {
  return new Promise((resolve, reject) => {

    $.ajax({
      url: '/cart/remove',
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

export const changeCartQuantity = (id, value, index) => {

  return new Promise((resolve, reject) => {

    $.ajax({
      url: '/cart/change',
      data: { id, value }
    })
      .done((res) => {
        if (!res) alert('Произошла ошибка. Попробуйте еще раз');
        
        const { services, quantity, total } = res.service;
       
        const sum = +services[id].price * +services[id].quantity;
        
        $('.total-list tbody tr').eq(index).find('.item-price').text(`${sum}`)
        $('#cart-total').text(total);
        $('#cart-quantity').text(quantity);

        updateCartDialog(res.service);

        resolve(cart)
      })
      .fail(function (error) {

        reject(error)
      });
  });
}
