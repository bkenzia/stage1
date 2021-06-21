const leftArrow = document.querySelector('.arrow--left');
const rightArrow = document.querySelector('.arrow--right');
const controlIndicatorElements = Array.from(document.querySelectorAll('.controls__indicator'));

const IMAGE_DURATION = 5000;

function checkIfActiveImage() {
  const carouselElement = document.querySelector('.carousel');
  const carouselImageElements = Array.from(carouselElement.querySelectorAll('img'));
  const controlIndicatorElements = Array.from(document.querySelectorAll('.controls__indicator'));
  let activeImage = carouselImageElements.find((element) => element.classList.contains('active'));

  if (!activeImage) {
    carouselImageElements[0].classList.add('active');
    controlIndicatorElements[0].classList.add('active');
  }
}

function setImageInterval(duration) {
  return setInterval(() => imageChangeHandler({ direction: 'next' }), duration);
}

function imageChangeHandler(params) {
  const { direction, imageIndex } = params;
  checkParams(params);

  clearInterval(interval);
  interval = setImageInterval(IMAGE_DURATION);

  if (!direction) {
    changeImageByIndex({ className: '.carousel img', imageIndex });
    changeImageByIndex({ className: '.controls__indicator', imageIndex });

    return;
  }

  let activeImage = getActiveElement('.carousel img');
  let activeIndicator = getActiveElement('.controls__indicator');

  changeImage({
    nodeName: 'IMG',
    className: '.carousel img',
    activeElement: activeImage,
    direction,
  });

  changeImage({
    nodeName: 'DIV',
    className: '.controls__indicator',
    activeElement: activeIndicator,
    direction,
  });
}

function changeImageByIndex(params) {
  const { className, imageIndex } = params;

  const elements = Array.from(document.querySelectorAll(className));

  for (let i = 0; i < elements.length; i++) {
    elements[i].classList.remove('active');
  }

  elements[imageIndex].classList.add('active');
}

function changeImage(params) {
  const { nodeName, className, activeElement, direction } = params;

  if (activeElement[`${direction}ElementSibling`]?.nodeName === nodeName) {
    activeElement[`${direction}ElementSibling`].classList.add('active');
    activeElement.classList.remove('active');
    return;
  }

  const containerElement = Array.from(document.querySelectorAll(className));
  const index = getImageIndex(direction);

  containerElement[index].classList.add('active');
  activeElement.classList.remove('active');
}

function getActiveElement(className) {
  const element = Array.from(document.querySelectorAll(className));
  return element.find((element) => element.classList.contains('active'));
}

function getImageIndex(direction) {
  const carouselImageElements = Array.from(document.querySelectorAll('.carousel img'));
  return direction === 'next' ? 0 : carouselImageElements.length - 1;
}

function checkParams(params) {
  if (!('imageIndex' in params) && !('direction' in params))
    throw new Error("L'objet de configuration n'est pas correct !");
}

function keyUpHandler(event) {
  const { key } = event;

  if (key === 'ArrowLeft') {
    imageChangeHandler({ direction: 'previous' });
  } else if (key === 'ArrowRight') {
    imageChangeHandler({ direction: 'next' });
  }
}

let interval = setImageInterval(IMAGE_DURATION);

// rightArrow.addEventListener('click', imageChangeHandler.bind(null, 'next'));
// leftArrow.addEventListener('click', imageChangeHandler.bind(null, 'previous'));

rightArrow.addEventListener('click', () => imageChangeHandler({ direction: 'next' }));
leftArrow.addEventListener('click', () => imageChangeHandler({ direction: 'previous' }));
document.addEventListener('keyup', keyUpHandler);

controlIndicatorElements.forEach((element, index) => {
  element.addEventListener('click', (event) => {
    imageChangeHandler({ imageIndex: index });
  });
});

checkIfActiveImage();

// document.querySelector('header').addEventListener('click', (e) => {
//   e.stopPropagation();
//   console.log('header click');
// });
// document.body.addEventListener('click', () => console.log('body click'));