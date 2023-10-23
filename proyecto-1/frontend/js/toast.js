function showToast(text, color, toast) {
    toast.classList.add(`text-bg-${color}`);
    toast.children.item(0).children.item(0).innerHTML = text;
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
    toastBootstrap.show();
}