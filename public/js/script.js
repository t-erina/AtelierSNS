(() => {
  const el = document;

  // hamburger btn
  const navBtn = el.getElementById('nav-btn'),
    navList = el.getElementById('nav-list');

  navBtn.addEventListener('click', (e) => {
    e.preventDefault();
    if (navBtn.classList.contains('is_active')) {
      navBtn.classList.remove('is_active');
      navList.classList.remove('is_active');
    } else {
      navBtn.classList.add('is_active');
      navList.classList.add('is_active');
    }
  });


  // follow btn
  const followBtn = el.querySelectorAll('.follow-btn'),
    unfollowBtn = el.querySelectorAll('.unfollow-btn');

  class DisplayFollowBtn {
    constructor(triggerBtn, targetBtn) {
      this.triggerBtn = triggerBtn;
      this.targetBtn = targetBtn;
    }

    btnToggle = () => {
      if (this.triggerBtn.classList.contains('is_active')) {
        this.triggerBtn.classList.remove('is_active')
        this.targetBtn.classList.add('is_active');
      }
    }
  }

  const setFollowRequest = (e) => {
    e.preventDefault();
    const triggerBtn = e.currentTarget,
      targetBtn = triggerBtn.nextElementSibling,
      userId = triggerBtn.getAttribute('user_id');

    const token = el.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      url = triggerBtn.dataset.route;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
      },
      data: {
        user_id: userId,
      },
    }).then((Response) => {
      if (Response.ok) {
        return Response.json();
      }
      throw new Error();
    }).then(() => {
      const displayBtn = new DisplayFollowBtn(triggerBtn, targetBtn);
      displayBtn.btnToggle();
    }).catch((error) => {
      throw new Error();
    });
  }

  const setUnfollowRequest = (e) => {
    e.preventDefault();
    const triggerBtn = e.currentTarget,
      targetBtn = triggerBtn.previousElementSibling,
      userId = triggerBtn.getAttribute('user_id');

    const token = el.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      url = triggerBtn.dataset.route;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
      },
      data: {
        user_id: userId,
      },
    }).then((Response) => {
      if (Response.ok) {
        return Response.json();
      }
      throw new Error();
    }).then(() => {
      const displayBtn = new DisplayFollowBtn(triggerBtn, targetBtn);
      displayBtn.btnToggle();
    }).catch((error) => {
      throw new Error();
    });
  }

  const btnLen_follow = followBtn.length,
    btnLen_unfollow = unfollowBtn.length;

  let i_follow = 0;
  while (i_follow < btnLen_follow) {
    followBtn[i_follow].addEventListener("click", (e) => setFollowRequest(e));
    i_follow++;
  }

  let i_unfollow = 0;
  while (i_unfollow < btnLen_unfollow) {
    unfollowBtn[i_unfollow].addEventListener("click", (e) => setUnfollowRequest(e));
    i_unfollow++;
  }

  // like btn
  const storeLikeBtn = el.querySelectorAll(".store-like-btn"),
    deleteLikeBtn = el.querySelectorAll(".delete-like-btn");

  class DisplayLikeBtn {
    constructor(toriggerBtn, targetBtn) {
      this.toriggerBtn = toriggerBtn;
      this.targetBtn = targetBtn;
    }

    btnToggle() {
      if (this.toriggerBtn.classList.contains("is_paused")) {
        this.toriggerBtn.classList.remove("is_paused");
      } else if (this.toriggerBtn.classList.contains("is_active")) {
        this.toriggerBtn.classList.remove("is_active");
      }
      this.targetBtn.classList.add("is_active");
    }
  }

  const toggleStoreLikeBtn = (e) => {
    e.preventDefault();
    const toriggerBtn = e.currentTarget,
      targetBtn = toriggerBtn.nextElementSibling,
      postId = toriggerBtn.getAttribute('post_id');

    const token = el.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      url = toriggerBtn.dataset.route;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
      },
      data: {
        post_id: postId,
      },
    }).then((Response) => {
      if (Response.ok) {
        return Response.json();
      }
      throw new Error();
    }).then(() => {
      const storeLike = new DisplayLikeBtn(toriggerBtn, targetBtn);
      storeLike.btnToggle();
    }).catch(error => {
      throw new Error();
    });
  }

  const toggleDeleteLikeBtn = (e) => {
    e.preventDefault();
    const toriggerBtn = e.currentTarget,
      targetBtn = toriggerBtn.previousElementSibling,
      postId = toriggerBtn.getAttribute('post_id');

    const token = el.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      url = toriggerBtn.dataset.route;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
      },
      data: {
        post_id: postId,
      },
    }).then((Response) => {
      if (Response.ok) {
        return Response.json();
      }
      throw new Error();
    }).then(() => {
      const deleteLike = new DisplayLikeBtn(toriggerBtn, targetBtn);
      deleteLike.btnToggle();
    }).catch(error => {
      throw new Error();
    });
  }

  const btnLen_storeLike = storeLikeBtn.length,
    btnLen_deleteLike = deleteLikeBtn.length;

  let i_storeLike = 0;
  while (i_storeLike < btnLen_storeLike) {
    storeLikeBtn[i_storeLike].addEventListener('click', (e) =>
      toggleStoreLikeBtn(e));
    i_storeLike++;
  }

  let i_deleteLike = 0;
  while (i_deleteLike < btnLen_deleteLike) {
    deleteLikeBtn[i_deleteLike].addEventListener('click', (e) =>
      toggleDeleteLikeBtn(e));
    i_deleteLike++;
  }

})();
