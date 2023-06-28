window.onscroll = function() {
    const header = document.getElementsByClassName("header")[0];
    const hide = document.getElementsByClassName("header-icons-item-hide")
    if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
        header.classList.add("header-end")
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            header.classList.add("header-start")
            for(let i = 0; i < hide.length; i++){
                hide[i].style.display = "none"     
            }

        } else {
            header.classList.remove("header-start")
        }
    } else {
        header.classList.remove("header-end")
        for(let i = 0; i < hide.length; i++){
            hide[i].style.display = "flex"
        }

    }
}

function clickClose(){
    document.getElementsByClassName("user-form-login")[0].style.display = 'none';
    document.getElementsByClassName("user-form-register")[0].style.display = 'none';
    document.getElementsByClassName("user-form-reset-password")[0].style.display = 'none';
    document.getElementsByClassName("user")[0].style.opacity = '0';
    document.getElementsByClassName("user")[0].style.visibility = 'hidden';
}

function clickLogin(){
    document.getElementsByClassName("user-form-login")[0].style.display = 'block';
    document.getElementsByClassName("user-form-register")[0].style.display = 'none';
    document.getElementsByClassName("user-form-reset-password")[0].style.display = 'none';
    document.getElementsByClassName("user-text-item user-text-login")[0].style.background = '#f4f2f2';
    document.getElementsByClassName("user-text-item user-text-register")[0].style.background = '#fff';
    document.getElementsByClassName("user")[0].style.opacity = '1';
    document.getElementsByClassName("user")[0].style.visibility = 'visible';
}

function clickRegister(){
    document.getElementsByClassName("user-form-login")[0].style.display = 'none';
    document.getElementsByClassName("user-form-register")[0].style.display = 'block';
    document.getElementsByClassName("user-form-reset-password")[0].style.display = 'none';
    document.getElementsByClassName("user-text-item user-text-login")[0].style.background = '#fff';
    document.getElementsByClassName("user-text-item user-text-register")[0].style.background = '#f4f2f2';
    document.getElementsByClassName("user")[0].style.opacity = '1';
    document.getElementsByClassName("user")[0].style.visibility = 'visible';
}


function clickResetPassword(){
    document.getElementsByClassName("user-form-login")[0].style.display = 'none';
    document.getElementsByClassName("user-form-register")[0].style.display = 'none';
    document.getElementsByClassName("user-form-reset-password")[0].style.display = 'block';
    document.getElementsByClassName("user-text-item user-text-login")[0].style.background = '#f4f2f2';
    document.getElementsByClassName("user-text-item user-text-register")[0].style.background = '#f4f2f2';
    document.getElementsByClassName("user")[0].style.opacity = '1';
    document.getElementsByClassName("user")[0].style.visibility = 'visible';
}


function closeCart(){
    document.getElementsByClassName("header-cart")[0].style.opacity = '0';
    document.getElementsByClassName("header-cart")[0].style.visibility = 'hidden';
    document.getElementsByClassName("header-cart-wrapper")[0].style.width = '0';
}

function openCart(){
    document.getElementsByClassName("header-cart")[0].style.opacity = '1';
    document.getElementsByClassName("header-cart")[0].style.visibility = 'visible';
    document.getElementsByClassName("header-cart-wrapper")[0].style.width = '400px';


}

function closeMenu(){
    document.getElementsByClassName("header-menu")[0].style.opacity = '0';
    document.getElementsByClassName("header-menu")[0].style.visibility = 'hidden';
    document.getElementsByClassName("header-menu-wrapper")[0].style.width = '0';

}

function openMenu(){
    document.getElementsByClassName("header-menu")[0].style.opacity = '1';
    document.getElementsByClassName("header-menu")[0].style.visibility = 'visible';
    document.getElementsByClassName("header-menu-wrapper")[0].style.width = '20%';
}

const amount = document.getElementsByClassName('product-detail-wrapper-top-right-quantity-number');
      const minus = document.getElementsByClassName('product-detail-wrapper-top-right-quantity-minus');
      const plus = document.getElementsByClassName('product-detail-wrapper-top-right-quantity-plus');

      let num = 1;
      for(let i = 0; i < amount.length; i++){
      plus[i].addEventListener("click", () => {
         num++;
         if(num == 0 || num < 0){
            num = 1;
         }else if(num < 100){
            num;
         }else{
            num = 99;
         }
         amount[i].innerText = num;
      })

      minus[i].addEventListener("click", () => {
         num--;
         if(num == 0 || num < 0){
            num = 1;
         }else{
            num
         }
         amount[i].innerText = num;
      })
      }
