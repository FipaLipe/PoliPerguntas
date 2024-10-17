async function form_json(sender, endpoint) {
    const formData = new FormData(sender);

    const formObj = {};
    formData.forEach((value, key) => {
        formObj[key] = value;
    });

    return await fetch('../backend/'+endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formObj)
    });

}