import React, { useEffect, useState } from "react";
import TextInput from "@/Components/TextInput";
import axios from "axios";

const BreweriesList = ({}) => {
    const [keyword, setKeyword] = useState("");
    const [loading, setLoading] = useState(false);
    const [breweries, setBreweries] = useState();

    const handleSearch = async (event) => {
        setKeyword(event.target.value);

        try {
            if (event.target.value) {
                setLoading(true);
                const response = await axios.get(
                    `/breweries/${event.target.value}`
                );

                if (response && response.data) {
                    setBreweries(response.data);
                }
                setLoading(false);
            } else {
                setBreweries([]);
            }
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <div className="flex flex-col justify-start items-center h-screen gap-4 mt-5">
            <h1>Welcome to the Breweries Page</h1>
            <TextInput
                type="search"
                placeholder="Search breweries by name"
                className=" w-96"
                value={keyword}
                onChange={handleSearch}
            />
            {loading ? (
                <div className="flex justify-center items-center h-40">
                    <svg
                        className="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            className="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            strokeWidth="4"
                        />
                        <path
                            className="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-1.647zM12 20a8 8 0 100-16 8 8 0 000 16zm1-11h6m-3 3v6m-6-9a1 1 0 110-2 1 1 0 010 2z"
                        />
                    </svg>
                    <span className="text-gray-600">Loading...</span>
                </div>
            ) : (
                <table className="table-auto w-full">
                    <thead>
                        <tr>
                            <th className="px-4 py-2">ID</th>
                            <th className="px-4 py-2">Name</th>
                            <th className="px-4 py-2">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        {breweries &&
                            breweries.map((brewery) => (
                                <tr key={brewery.id}>
                                    <td className="border px-4 py-2">
                                        {brewery.id}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {brewery.name}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {`${brewery.address.street}, ${brewery.address.city}, ${brewery.address.state}, ${brewery.address.postal_code}`}
                                    </td>
                                </tr>
                            ))}
                    </tbody>
                </table>
            )}
        </div>
    );
};

export default BreweriesList;
