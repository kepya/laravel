/*
   fetch('http://172.17.0.2:4000/admin/facture/factureByYear/' + year, {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ${token}'
            },
            body: JSON.stringify({
                "email": email,
                "password": password
            })
        })
        .then( (response) => response.json())
        .then(data => {
            invoices = data;
        }).catch(error => {console.error('error : ' + error);});
*/
