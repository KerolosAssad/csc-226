import React, { useState, useEffect } from 'react';

export default function MyComponent() {
    const [data, setData] = useState(null);

    useEffect(() => {
        fetch('https://jsonplaceholder.typicode.com/users')
            .then(response => response.json())
            .then(data => setData(data));
    }, []);


    // render the component using the data from the API
    return <div>{JSON.stringify(data)}</div>;
}