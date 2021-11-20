function openFunction() {
	document.getElementById("cart").style.right="0";
	document.getElementById("back").style.left="0";
	document.getElementById("right_icon").style.right="-100%";
}
function closeFunction() {
	document.getElementById("cart").style.right="-100%";
	document.getElementById("back").style.left="100%";
	document.getElementById("right_icon").style.right="20px";
}
const plus = document.querySelectorAll(".plus"),
	minus = document.querySelectorAll(".minus"),
	num = document.querySelectorAll(".num")

let a = [];
for (i = 0; i < num.length; i++){
  a[i] = 1;
}

for (let i = 0; i < num.length; i++) {
	plus[i].addEventListener("click", function(){
		a[i]++;
		a[i] = (a[i] < 10) ? "0"+ a[i] : a[i];
		num[i].innerText = a[i];
		console.log(a[i]);
	});
	minus[i].addEventListener("click", function(){
		if (a[i] > 1){
			a[i]--;
			a[i] = (a[i] < 10) ? "0"+ a[i] : a[i];
			num[i].innerText = a[i];
			console.log(a[i]);
		}
	});
}
const categoryTitle = document.querySelectorAll('.category');
const allCategoryPosts = document.querySelectorAll('.all');

for(let i = 0; i < categoryTitle.length; i++){
    categoryTitle[i].addEventListener('click', filterPosts.bind(this, categoryTitle[i]));
}

function filterPosts(item){
    changeActivePosition(item);
    for(let i = 0; i < allCategoryPosts.length; i++){
        if(allCategoryPosts[i].classList.contains(item.attributes.id.value)){
            allCategoryPosts[i].style.display = "block";
        } else {
            allCategoryPosts[i].style.display = "none";
        }
    }
}

function changeActivePosition(activeItem){
    for(let i = 0; i < categoryTitle.length; i++){
        categoryTitle[i].classList.remove('active');
    }
    activeItem.classList.add('active');
};

