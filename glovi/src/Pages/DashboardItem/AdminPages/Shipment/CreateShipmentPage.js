import React, { useState } from "react";
import { FaTrash } from "react-icons/fa";
import Topbar from "../../AdminComponents/topbar/Topbar";
import Sidebar from "../../AdminComponents/sidebar/Sidebar";

function CreateShipmentPage() {
  const [formData, setFormData] = useState({
    customer: "",
    pickup: "",
    recipient: "",
    packages: [
      {
        description: "",
        length: "",
        width: "",
        height: "",
        weight: "",
        quantity: "",
        declaredValue: "",
      },
    ],
    trackingNumber: "",
    paymentMethod: "",
  });

  const handleChange = (e, index) => {
    const { name, value } = e.target;
    const updatedPackages = [...formData.packages];
    updatedPackages[index][name] = value;
    setFormData((prevData) => ({
      ...prevData,
      packages: updatedPackages,
    }));
  };

  const handleAddPackage = () => {
    setFormData((prevData) => ({
      ...prevData,
      packages: [
        ...prevData.packages,
        {
          description: "",
          length: "",
          width: "",
          height: "",
          weight: "",
          quantity: "",
          declaredValue: "",
        },
      ],
    }));
  };

  const handleDeletePackage = (index) => {
    if (index === 0) return;
    const updatedPackages = [...formData.packages];
    updatedPackages.splice(index, 1);
    setFormData((prevData) => ({
      ...prevData,
      packages: updatedPackages,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log(formData);
  };

  return (
    <>
      <Topbar />
      <div className="flex">
        <Sidebar />
        <div className="max-w-4xl mx-auto mt-8 p-4">
        <h1 className="text-3xl my-8 mx-4">Create New Shipment</h1>
          <form onSubmit={handleSubmit}>
            <div className="mb-6">
              <h2 className="text-xl font-semibold mb-2">Customer Information</h2>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label className="block mb-2">Customer</label>
                  <input
                    type="text"
                    name="customer"
                    value={formData.customer}
                    onChange={(e) => handleChange(e)}
                    className="input rounded-xl"
                  />
                </div>
                <div>
                  <label className="block mb-2">Pickup</label>
                  <input
                    type="text"
                    name="pickup"
                    value={formData.pickup}
                    onChange={(e) => handleChange(e)}
                    className="input rounded-xl"
                  />
                </div>
                <div>
                  <label className="block mb-2">Recipient</label>
                  <input
                    type="text"
                    name="recipient"
                    value={formData.recipient}
                    onChange={(e) => handleChange(e)}
                    className="input rounded-xl"
                  />
                </div>
              </div>
            </div>

            <div className="mb-6">
              <h2 className="text-xl font-semibold mb-2">Package Information</h2>
              {formData.packages.map((packageData, index) => (
                <div key={index} className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                  <div>
                    <label className="block mb-2">Description</label>
                    <input
                      type="text"
                      name="description"
                      value={packageData.description}
                      onChange={(e) => handleChange(e, index)}
                      className="input rounded-xl"
                    />
                  </div>
                  <div>
                    <label className="block mb-2">Length (CM)</label>
                    <input
                      type="text"
                      name="length"
                      value={packageData.length}
                      onChange={(e) => handleChange(e, index)}
                      className="input rounded-xl"
                    />
                  </div>
                  <div>
                    <label className="block mb-2">Width (CM)</label>
                    <input
                      type="text"
                      name="width"
                      value={packageData.width}
                      onChange={(e) => handleChange(e, index)}
                      className="input rounded-xl"
                    />
                  </div>
                  <div>
                    <label className="block mb-2">Height (CM)</label>
                    <input
                      type="text"
                      name="height"
                      value={packageData.height}
                      onChange={(e) => handleChange(e, index)}
                      className="input rounded-xl"
                    />
                  </div>
                  <div>
                    <label className="block mb-2">Weight (KG)</label>
                    <input
                      type="text"
                      name="weight"
                      value={packageData.weight}
                      onChange={(e) => handleChange(e, index)}
                      className="input rounded-xl"
                    />
                  </div>
                  <div>
                    <label className="block mb-2">Quantity</label>
                    <input
                      type="text"
                      name="quantity"
                      value={packageData.quantity}
                      onChange={(e) => handleChange(e, index)}
                      className="input rounded-xl"
                    />
                  </div>
                  <div>
                    <label className="block mb-2">Declared Value</label>
                    <input
                      type="text"
                      name="declaredValue"
                      value={packageData.declaredValue}
                      onChange={(e) => handleChange(e, index)}
                      className="input rounded-xl"
                    />
                  </div>
                  {index !== 0 && (
                    <div className="flex items-center">
                      <button
                        type="button"
                        className="text-red-500 hover:text-red-700"
                        onClick={() => handleDeletePackage(index)}
                      >
                        <FaTrash />
                      </button>
                    </div>
                  )}
                </div>
              ))}
              <button
                type="button"
                className="btn btn-secondary"
                onClick={handleAddPackage}
              >
                Add Package
              </button>
            </div>

            <div className="mb-6">
              <h2 className="text-xl font-semibold mb-2">Shipping Information</h2>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label className="block mb-2">Tracking Number</label>
                  <input
                    type="text"
                    name="trackingNumber"
                    value={formData.trackingNumber}
                    onChange={(e) => handleChange(e)}
                    className="input rounded-xl"
                  />
                </div>
                <div>
                  <label className="block mb-2">Payment Method</label>
                  <input
                    type="text"
                    name="paymentMethod"
                    value={formData.paymentMethod}
                    onChange={(e) => handleChange(e)}
                    className="input rounded-xl"
                  />
                </div>
              </div>
            </div>

            <div className="flex" style={{marginRight:"auto"}}>
              <button style={{ background: "brown" }} type="button" className="btn btn-danger mr-4">
                Discard
              </button>
              <button style={{ background: "#210c2d", marginLeft: "10px" }} type="submit" className="btn btn-primary">
                Proceed
              </button>
            </div>
          </form>
        </div>
      </div>
    </>
  );
}

export default CreateShipmentPage;
