(() => {
  const el = document;

  // form display toggle
  class setTextCountValidator {
    constructor(field, counter, submitBtn, maxLen) {
      this.field = field;
      this.counter = counter;
      this.maxLen = maxLen;
      this.submitBtn = submitBtn;
    }

    textCountValidate() {
      const num = parseInt(this.field.textContent.length);
      this.counter.innerHTML = num + '/' + this.maxLen;
      console.log('!');

      if (num === this.maxLen) {
        if (this.submitBtn.hasAttribute('disabled')) {
          this.submitBtn.removeAttribute('disabled');
        }
      } else if (!(0 < num < this.maxLen)) {
        if (!this.submitBtn.hasAttribute('disabled')) {
          this.submitBtn.addAttribute('disabled');
        }
      }
    }
  }

  const comment = el.querySelector('.comment');
  const field = comment.querySelector('.f-comment-update_comment'),
    counter = field.nextElementSibling,
    submitBtn = comment.querySelector('.comment-update-form_submit-btn'),
    maxLen = 400;

  const textContentCheck = new setTextCountValidator(field, counter, submitBtn, maxLen);
  field.addEventListener('keyup', textContentCheck.textCountValidate());


  const commentEditBtn = el.querySelectorAll('.comment-edit-btn');
  const commentFormCloseBtn = el.querySelectorAll('.comment-update-form_close-btn');

  const showCommentEditForm = (e) => {
    e.preventDefault();
    const torigger = e.currentTarget,
      index = torigger.dataset.btnid,
      target = el.querySelector('[data-contentid = "' + index + '"]'),
      targetState = target.classList;

    if (!targetState.contains('is_active')) {
      targetState.add('is_active');
    }
  }

  const closeCommentEditForm = (e) => {
    e.preventDefault();
    const torigger = e.currentTarget,
      index = torigger.dataset.closebtnid,
      target = el.querySelector('[data-contentid = "' + index + '"]'),
      targetState = target.classList;


    if (targetState.contains('is_active')) {
      targetState.remove('is_active');
    }
  }

  const commentEditBtnLen = commentEditBtn.length;
  let i_commentEditBtn = 0;
  while (i_commentEditBtn < commentEditBtnLen) {
    commentEditBtn[i_commentEditBtn].addEventListener('click', (e) => showCommentEditForm(e));
    i_commentEditBtn++;
  }

  const commentFormCloseBtnLen = commentFormCloseBtn.length;
  let i_commentFormCloseBtn = 0;
  while (i_commentFormCloseBtn < commentFormCloseBtnLen) {
    commentFormCloseBtn[i_commentFormCloseBtn].addEventListener('click', (e) => closeCommentEditForm(e));
    i_commentFormCloseBtn++;
  }
})()
