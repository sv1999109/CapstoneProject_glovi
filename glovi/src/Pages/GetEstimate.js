import React, { useState, useEffect  } from "react";
import Header from '../Components/Header'
import Footer from '../Components/Footer'
import './GetEstimateStyle.css'

function GetEstimate() {
    const [items, setItems] = useState([]);

    useEffect(() => {
        // Mimic componentDidMount to add an initial item
        setItems(prevItems => [<GetItemDetails key={prevItems.length} onDelete={() => deleteItem(prevItems.length)} />]);
    }, []); // Empty dependency array ensures this runs only once on component mount

    const addItemToPackage = () => {
        setItems(prevItems => [...prevItems, <GetItemDetails key={prevItems.length} onDelete={() => deleteItem(prevItems.length)} />]);
    };

    const deleteItem = (index) => {
        // Do not delete the item if there is only one left
        if (items.length === 1) return;
        setItems(prevItems => prevItems.filter((_, i) => i !== index));
    };


    return (
        <>
            <Header />
            <div id="HeaderSpace"></div>
            
            <div id="pickupAndDeliveryAddressSection" className="estimate-sections">
                <div className="pickup-and-delivery-address">
                    <div className="get-estimate-headings" style={{ textAlign: 'left', marginLeft: '15%'}}>
                        <h2>Pickup Address</h2>
                    </div>
                    <GetAddress/>
                </div>
                <div className="pickup-and-delivery-address">
                    <div className="get-estimate-headings" style={{ textAlign: 'right', marginRight: '15%'}}>
                        <h2>Delivery Address</h2>
                    </div>
                    <GetAddress/>
                </div>
            </div>

            <div id="packageDetailsSection" className="estimate-sections">
                <div id="package-details-head">
                    <div className="get-estimate-headings">
                        <h2>Package</h2>
                        <hr/>
                    </div>
                    <button id="addItemtoPackage"  onClick={addItemToPackage}>Add Item</button>
                </div>
                <div id="package-details">
                    {items}
                </div>
            </div>

            <div id="estimateResultsection" className="estimate-sections">
                <div id="estimateSubmitButtonBox"><button id="submitEstimateForm">Get an Estimate</button></div>
                <div id="estimateResultBox">
                    <span>Estimate: $</span>
                    <span id="estimateResultAnswer">00</span>
                </div>
            </div>
            <Footer />
        </>
    )
}

function GetAddress()
{
    return (
        <div className="address-form">
            <div className="address-input-item ">
                <select id="country" name="country" className="address-selects get-estimate-page-inputs">
                    <option value="usa">USA</option>
                    <option value="canada">Canada</option>
                </select>
                <label for="country" className="address-labels get-estimate-page-labels">Country:</label>
            </div>

            <div className="address-input-item">
                <select id="state" name="state" className="address-selects get-estimate-page-inputs">
                    <option value="ny">New York</option>
                    <option value="ca">California</option>
                    <option value="on">Ontario</option>
                    <option value="bc">British Columbia</option>
                </select>
                <label for="state" className="address-labels get-estimate-page-labels">State/Province:</label>
            </div>

            <div className="address-input-item">
                
                <select id="city" name="city" className="address-selects get-estimate-page-inputs">
                    <option value="nyc">New York City</option>
                    <option value="buf">Buffalo</option>
                    <option value="la">Los Angeles</option>
                    <option value="sf">San Francisco</option>
                </select>
                <label for="city" className="address-labels get-estimate-page-labels">City:</label>
            </div>

            <div className="address-input-item">
                
                <input type="text" id="addressinput" name="address" className="address-inputs get-estimate-page-inputs"/>
                <label for="address" className="address-labels get-estimate-page-labels">Address:</label>
            </div>

            <div className="address-input-item">
                
                <input type="text" id="postalCode" name="postalCode" className="address-inputs get-estimate-page-inputs"/>
                <label for="postalCode" className="address-labels get-estimate-page-labels">Postal Code:</label>
            </div>
      </div>
    )
}

function GetItemDetails({ onDelete }) {
    const [parcelType, setParcelType] = useState('');
    const [dimensions, setDimensions] = useState({
        width: '',
        length: '',
        height: '',
    });
    const [weight, setWeight] = useState('');
    const [quantity, setQuantity] = useState('');
    const [declaredValue, setDeclaredValue] = useState('');

    const handleParcelTypeChange = (e) => {
        setParcelType(e.target.value);
        // Set default dimensions and weight based on the selected parcel type
        if (e.target.value === 'envelope') {
            setDimensions({ width: '10', length: '15', height: '0' });
            setWeight('1');
        } else if (e.target.value === 'box') {
            setDimensions({ width: '20', length: '30', height: '10' });
            setWeight('1');
        }
    };

    const handleDimensionChange = (e) => {
        const { name, value } = e.target;
        setDimensions(prevDimensions => ({
            ...prevDimensions,
            [name]: value
        }));
    };

    const handleDelete = () => {
        onDelete();
    };

    return (
        <div className="parcel-details">
            <span className="parcel-details-input">
                <select id="parcelType" value={parcelType} onChange={handleParcelTypeChange} className="parcel-select get-estimate-page-inputs">
                    <option value="">Select Parcel Type</option>
                    <option value="envelope">Envelope</option>
                    <option value="box">Box</option>
                </select>
                <label htmlFor="parcelType" for="parcelType" className="parcel-label get-estimate-page-labels">Parcel Type:</label>
            </span>
            <span className="parcel-details-input">
                <input type="number" id="width" name="width" value={dimensions.width} onChange={handleDimensionChange} className="parcel-details-input-field get-estimate-page-inputs" placeholder="placeholder"/>
                <label htmlFor="width" for="width" className="parcel-details-label get-estimate-page-labels">Width (cm):</label>
            </span>
            <span className="parcel-details-input">
                <input type="number" id="length" name="length" value={dimensions.length} onChange={handleDimensionChange} className="parcel-details-input-field get-estimate-page-inputs" />
                <label htmlFor="length" for="length" className="parcel-details-label get-estimate-page-labels">Length (cm):</label>
            </span>
            <span className="parcel-details-input">
                <input type="number" id="height" name="height" value={dimensions.height} onChange={handleDimensionChange} className="parcel-details-input-field get-estimate-page-inputs" />
                <label htmlFor="height" for="height" className="parcel-details-label get-estimate-page-labels">Height (cm):</label>
            </span>
            <span className="parcel-details-input">
                <input type="number" id="weight" name="weight" value={weight} onChange={(e) => setWeight(e.target.value)} className="parcel-details-input-field get-estimate-page-inputs" />
                <label htmlFor="weight" for="weight" className="parcel-details-label get-estimate-page-labels">Weight (kg):</label>
            </span>
            <span className="parcel-details-input">
                <input type="number" id="quantity" name="quantity" value={quantity} onChange={(e) => setQuantity(e.target.value)} className="parcel-details-input-field get-estimate-page-inputs" />
                <label htmlFor="quantity" for="quantity" className="parcel-details-label get-estimate-page-labels">Quantity:</label>
            </span>
            <span className="parcel-details-input">
                <input type="number" id="declaredValue" name="declaredValue" value={declaredValue} onChange={(e) => setDeclaredValue(e.target.value)} className="parcel-details-input-field get-estimate-page-inputs" />
                <label htmlFor="declaredValue" for="declaredValue" className="parcel-details-label get-estimate-page-labels">Dec. Value:</label>
            </span>
            <span className="parcel-details-input">
                <button id="deleteItem" onClick={handleDelete}>Delete Item</button>
            </span>
        </div>
    );
}





export default GetEstimate