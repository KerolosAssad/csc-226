import React, { useState, useEffect } from 'react';

export default function MyComponent() {
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchQuery, setSearchQuery] = useState('');
    const [filteredData, setFilteredData] = useState([]);
    const [sortField, setSortField] = useState('calories');
    const [sortOrder, setSortOrder] = useState('asc'); // 'asc' for ascending, 'desc' for descending

    useEffect(() => {
        fetch('http://localhost:80/api/newApi.php')
            .then(response => response.json())
            .then(data => {
                const formattedData = data.map(item => ({
                    name: item.name,
                    family: item.family,
                    order: item.order,
                    genus: item.genus,
                    nutritions: item.nutritions
                }));

                setData(formattedData);
                setFilteredData(formattedData);
                setLoading(false);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                setLoading(false);
            });
    }, []);

    const handleSearch = query => {
        setSearchQuery(query);
        const filtered = data.filter(item =>
            item.name.toLowerCase().includes(query.toLowerCase())
        );
        setFilteredData(filtered);
    };

    const handleSort = () => {
        const sortedData = [...filteredData].sort((a, b) => {
            const valueA = a.nutritions[sortField];
            const valueB = b.nutritions[sortField];

            if (sortOrder === 'asc') {
                return valueA - valueB;
            } else {
                return valueB - valueA;
            }
        });

        setFilteredData(sortedData);
    };

    if (loading) {
        return <div>Loading...</div>;
    }

    const displayData = filteredData.length ? filteredData : null;

    return (
        <div>
            <div className="SearchBox">
                <h2>Search Fruits:</h2>
                <input
                    type="text"
                    value={searchQuery}
                    onChange={e => handleSearch(e.target.value)}
                />
            </div>
            <div className={"SortOrderDropdown"}>
                <h2>Sort Order:</h2>
                <select value={sortField} onChange={e => setSortField(e.target.value)}>
                    <option value="calories">Calories</option>
                    <option value="fat">Fat</option>
                    <option value="sugar">Sugar</option>
                    <option value="carbohydrates">Carbohydrates</option>
                    <option value="protein">Protein</option>
                </select>
                <select value={sortOrder} onChange={e => setSortOrder(e.target.value)}>
                    <option value="asc">Low to High</option>
                    <option value="desc">High to Low</option>
                </select>
                <button onClick={handleSort}>Sort</button>
            </div>
            <h2>Results:</h2>
            <div className="Result">
                {displayData ? (
                    displayData.map(item => (
                        <div key={item.name}>
                            <div>{`Name: ${item.name}`}</div>
                            <div>{`Family: ${item.family}`}</div>
                            <div>{`Order: ${item.order}`}</div>
                            <div>{`Genus: ${item.genus}`}</div>
                            <div><br/></div>
                            <div>{`Nutritional Information:`}</div>
                            <div>{`  Calories: ${item.nutritions.calories}`}</div>
                            <div>{`  Fat: ${item.nutritions.fat}`}</div>
                            <div>{`  Sugar: ${item.nutritions.sugar}`}</div>
                            <div>{`  Carbohydrates: ${item.nutritions.carbohydrates}`}</div>
                            <div>{`  Protein: ${item.nutritions.protein}`}</div>
                            <hr />
                        </div>
                    ))
                ) : (
                    <div>No matching results found</div>
                )}
            </div>
        </div>
    );
}
