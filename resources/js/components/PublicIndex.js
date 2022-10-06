// resources/js/components/HelloReact.js

import React from 'react';
import { createRoot } from 'react-dom/client';

function PublicIndex() {
    useEffect(() => {
        var URLactual = window.location.pathname;
        let array = URLactual.split('/');
        
        fetch('/api/public/2236', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
        .then(res => res.json())
        .then(response => {
        const  data  = response
        });

        console.log(data);
    });

    return (
        <h1>Hello sReact!</h1>
    );
}

const container = document.getElementById('public-index');
const root = createRoot(container);
root.render(<PublicIndex />)