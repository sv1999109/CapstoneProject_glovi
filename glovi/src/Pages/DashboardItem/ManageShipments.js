import React, { useState } from "react";
import { DataGrid } from "@mui/x-data-grid";
import { Edit, Delete } from "@mui/icons-material";
import Topbar from "./AdminComponents/topbar/Topbar";
import Sidebar from "./AdminComponents/sidebar/Sidebar";

export default function ManageShipments() {
  const [shipments, setShipments] = useState([
    {
      id: 1,
      trackingNumber: "ABC123456",
      status: "In Transit",
      shippingCost: "$50",
      customer: "John Doe",
      sender: "Company A",
      receiver: "Company B",
      origin: "New York",
      destination: "Los Angeles",
      created: "2024-04-15T10:30:00",
    },
    {
      id: 2,
      trackingNumber: "DEF789012",
      status: "Delivered",
      shippingCost: "$75",
      customer: "Jane Smith",
      sender: "Company C",
      receiver: "Company D",
      origin: "Chicago",
      destination: "Houston",
      created: "2024-04-14T12:45:00",
    },
    { id: 3,
      trackingNumber: "GHI345678",
      status: "In Transit",
      shippingCost: "$60",
      customer: "Bob Johnson",
      sender: "Company E",
      receiver: "Company F",
      origin: "Miami",
      destination: "Seattle",
      created: "2024-04-13T09:15:00",
    },
  ]);

  const [editedShipment, setEditedShipment] = useState(null);

  const columns = [
    { field: "trackingNumber", headerName: "Tracking Number", width: 150 },
    { field: "status", headerName: "Status", width: 120 },
    { field: "shippingCost", headerName: "Shipping Cost", width: 130 },
    { field: "customer", headerName: "Customer", width: 130 },
    { field: "sender", headerName: "Sender", width: 130 },
    { field: "receiver", headerName: "Receiver", width: 130 },
    { field: "origin", headerName: "Origin", width: 130 },
    { field: "destination", headerName: "Destination", width: 130 },
    { field: "created", headerName: "Created", width: 150 },
    {
      field: "action",
      headerName: "Action",
      width: 120,
      renderCell: (params) => (
        <>
          <Edit
            className="cursor-pointer text-blue-500 hover:text-blue-700"
            onClick={() => handleEdit(params.row)}
          />
          <Delete
            className="cursor-pointer text-red-500 hover:text-red-700 ml-2"
            onClick={() => handleDelete(params.row.id)}
          />
        </>
      ),
    },
  ];

  const handleEdit = (shipment) => {
    setEditedShipment({ ...shipment });
  };

  const handleDelete = (id) => {
    const updatedShipments = shipments.filter((shipment) => shipment.id !== id);
    setShipments(updatedShipments);
  };

  const handleFieldChange = (e, field) => {
    setEditedShipment({
      ...editedShipment,
      [field]: e.target.value,
    });
  };

  const handleSaveEdit = () => {
    const index = shipments.findIndex((shipment) => shipment.id === editedShipment.id);
    const updatedShipments = [...shipments];
    updatedShipments[index] = editedShipment;
    setEditedShipment(null);
    setShipments(updatedShipments);
  };

  const handleCancelEdit = () => {
    setEditedShipment(null);
  };

  return (
    <>
      <Topbar />
      <div className="flex">
        <Sidebar />
        <div style={{ width: "80%" }} className="h-full">
          <h1 className="text-3xl my-8 mx-4">Manage Shipments</h1>
          <DataGrid
            rows={editedShipment ? [...shipments, editedShipment] : shipments}
            columns={columns}
            pageSize={5}
            rowsPerPageOptions={[5, 10, 20]}
            checkboxSelection
            disableSelectionOnClick
          />
          {editedShipment && (
            <div className="flex justify-end mt-4">
              <button
                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mr-4"
                onClick={handleSaveEdit}
              >
                Apply Changes
              </button>
            </div>
          )}
        </div>
      </div>
      {editedShipment && (
        <div className="absolute top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center">
          <div className="bg-white p-4 rounded-lg">
            <h2 className="text-xl font-bold mb-2">Edit Shipment</h2>
            <div className="flex flex-col space-y-2">
              <input
                type="text"
                value={editedShipment.trackingNumber}
                onChange={(e) => handleFieldChange(e, "trackingNumber")}
                placeholder="Tracking Number"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="text"
                value={editedShipment.status}
                onChange={(e) => handleFieldChange(e, "status")}
                placeholder="Status"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="text"
                value={editedShipment.shippingCost}
                onChange={(e) => handleFieldChange(e, "shippingCost")}
                placeholder="Shipping Cost"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="text"
                value={editedShipment.customer}
                onChange={(e) => handleFieldChange(e, "customer")}
                placeholder="Customer"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="text"
                value={editedShipment.sender}
                onChange={(e) => handleFieldChange(e, "sender")}
                placeholder="Sender"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="text"
                value={editedShipment.receiver}
                onChange={(e) => handleFieldChange(e, "receiver")}
                placeholder="Receiver"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="text"
                value={editedShipment.origin}
                onChange={(e) => handleFieldChange(e, "origin")}
                placeholder="Origin"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="text"
                value={editedShipment.destination}
                onChange={(e) => handleFieldChange(e, "destination")}
                placeholder="Destination"
                className="border rounded-md px-2 py-1"
              />
              <input
                type="datetime-local"
                value={editedShipment.created}
                onChange={(e) => handleFieldChange(e, "created")}
                placeholder="Created"
                className="border rounded-md px-2 py-1"
              />
              {/* Apply Changes button */}
              <button
                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
                onClick={handleSaveEdit}
              >
                Apply Changes
              </button>
              <button
                className="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full"
                onClick={handleCancelEdit}
              >
                Cancel
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
