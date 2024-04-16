import React, { useState } from "react";
import { DataGrid } from "@mui/x-data-grid";
import { DeleteOutline } from "@mui/icons-material";
import { Link } from "react-router-dom";
import Sidebar from "../DashboardItem/AdminComponents/sidebar/Sidebar";
import Topbar from "../DashboardItem/AdminComponents/topbar/Topbar";

export default function AddressBook() {
  const [addresses, setAddresses] = useState([
    {
      _id: 1,
      addressType: 'Business',
      address: 'Seth Boamah Antwi, Kasoa akweley, Kasoa, Central, Ghana, +233558554922, sboamah42@gmail.com',
      createdAt: '2022-10-02'
    },
    {
      _id: 2,
      addressType: 'Residential',
      address: '164 Taradale Drive, NE',
      createdAt: '2022-10-02'
    },
    {
      _id: 3,
      addressType: 'Residential',
      address: '184 Taralake Way, NE',
      createdAt: '2022-10-02'
    }
  ]);

  const handleDelete = (id) => {
    setAddresses(addresses.filter(address => address._id !== id));
  };

  const columns = [
    { field: "addressType", headerName: "Address Type", width: 150 },
    { field: "address", headerName: "Address", width: 720 },
    { field: "createdAt", headerName: "Created", width: 120 },
    {
      field: "action",
      headerName: "Action",
      width: 150,
      renderCell: (params) => {
        return (
          <>
            <Link to={"/CurrentOrder/"  + params.row.username  + "/" + params.row.orderNo}>
              <button className="productListEdit">Respond</button>
            </Link>
            <DeleteOutline
              className="productListDelete"
              onClick={() => handleDelete(params.row._id)}
            />
          </>
        );
      },
    },
  ];

  const [popupActive, setPopupActive] = useState(false);
  const [popupContent, setPopupContent] = useState(null);

  function togglePopup(content) {
    setPopupContent(content);
    setPopupActive(!popupActive);
  }

  const handleAddAddressClick = () => {
    const addressForm = (
      <div className="popupContent" style={{ position: 'relative' }} onClick={(e) => e.stopPropagation()}>
        <h2 style={{ textAlign: "center", fontWeight: "bolder", fontSize: "45px" }}>Add Address</h2>

        <div style={{ maxWidth: '560px', marginRight: "auto", marginLeft: "auto", marginTop: "61px", background: "lightgray", padding: "35px", position: 'relative'}} onClick={(e) => e.stopPropagation()}>
          <div style={{ marginBottom: '1rem' }}>
            <label htmlFor="addressType">Address Type:</label>
            <select id="addressType" style={{ width: '100%', padding: '0.5rem', border: '1px solid #ccc', borderRadius: '4px', fontSize: '1rem' }}>
              <option value="Residential">Residential</option>
              <option value="Business">Business</option>
            </select>
          </div>
          <div style={{ marginBottom: '1rem' }}>
            <label htmlFor="address">Address:</label>
            <input type="text" id="address" style={{ width: '100%', padding: '0.5rem', border: '1px solid #ccc', borderRadius: '4px', fontSize: '1rem' }} />
          </div>
          <div style={{ marginBottom: '1rem' }}>
            <label htmlFor="created">Created:</label>
            <input type="date" id="created" style={{ width: '100%', padding: '0.5rem', border: '1px solid #ccc', borderRadius: '4px', fontSize: '1rem' }} />
          </div>
          <div style={{ textAlign: 'center' }}>
            <button style={{ width: '100%', padding: '0.5rem', border: 'none', borderRadius: '4px', fontSize: '1rem', backgroundColor: '#36134a', color: '#fff', cursor: 'pointer' }} onClick={handleAddAddressSubmit}>Add Address</button>
          </div>
        </div>
      </div>
    );
    togglePopup(addressForm);
  };

  const handleAddAddressSubmit = () => {
    const addressType = document.getElementById("addressType").value;
    const address = document.getElementById("address").value;
    const created = document.getElementById("created").value;

    const newAddress = {
      _id: addresses.length + 1,
      addressType: addressType,
      address: address,
      createdAt: created
    };

    setAddresses([...addresses, newAddress]);
    setPopupActive(false);
  };

  return (
    <>
      <Topbar/>
      <div className="flex justify-between">
        <Sidebar/>
        <div style={{ width: "80%" }} className="h-full">
          <div className="address-header">
            <h1 className="text-3xl my-8 mx-4">Address Book</h1>
            <div>
              <button className="add-address-button" onClick={handleAddAddressClick}>
                Add Address
              </button>
            </div>
          </div>
          <DataGrid
            rows={addresses}
            disableSelectionOnClick
            columns={columns}
            pageSize={8}
            checkboxSelection
            getRowId={(row) => row._id}
          />
        </div>
      </div>

      {popupActive && (
        <div className="Aboutpopup" id="popup-1">
          <div className="overlay" onClick={() => setPopupActive(false)}>
            <div className="popContent">
              <div className="close-btn" onClick={() => setPopupActive(false)}>
                &times;
              </div>
              {popupContent}
            </div>
          </div>
        </div>
      )}
    </>
  );
}
