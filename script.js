function buttonUpdate(btnID, id) {
  if (id in localStorage) {
    btnID.innerText = 'Remove from Wishlist';
  } else {
    btnID.innerText = 'Add to Wishlist';
  }
};