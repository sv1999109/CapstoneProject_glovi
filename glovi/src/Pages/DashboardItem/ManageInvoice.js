import React, { useState } from "react";
import { DataGrid } from "@mui/x-data-grid";
import { Edit, Delete, Visibility } from "@mui/icons-material";
import Modal from 'react-modal';
import Topbar from "../DashboardItem/AdminComponents/topbar/Topbar";
import Sidebar from "../DashboardItem/AdminComponents/sidebar/Sidebar";

export default function Payments() {
  const [invoices, setInvoices] = useState([
    {
      id: 1,
      customer: "John Doe",
      email: "john@example.com",
      amount: "$500",
      status: "Paid",
      created: "2024-04-15",
    },
    {
      id: 2,
      customer: "Jane Smith",
      email: "jane@example.com",
      amount: "$750",
      status: "Pending",
      created: "2024-04-14",
    },
  ]);

  const [modalIsOpen, setModalIsOpen] = useState(false);
  const [selectedInvoice, setSelectedInvoice] = useState(null);
  const [editedInvoice, setEditedInvoice] = useState(null);

  const openModal = (invoice) => {
    setSelectedInvoice(invoice);
    setEditedInvoice({ ...invoice });
    setModalIsOpen(true);
  };

  const closeModal = () => {
    setSelectedInvoice(null);
    setEditedInvoice(null);
    setModalIsOpen(false);
  };

  const handleFieldChange = (e, field) => {
    setEditedInvoice({
      ...editedInvoice,
      [field]: e.target.value,
    });
  };

  const handleSaveEdit = () => {
    const updatedInvoices = invoices.map((invoice) =>
      invoice.id === editedInvoice.id ? editedInvoice : invoice
    );
    setInvoices(updatedInvoices);
    closeModal();
  };

  const handleDelete = (id) => {
    const updatedInvoices = invoices.filter((invoice) => invoice.id !== id);
    setInvoices(updatedInvoices);
    closeModal();
  };

  const columns = [
    { field: "id", headerName: "ID", width: 100 },
    { field: "customer", headerName: "Customer", width: 200 },
    { field: "email", headerName: "Email", width: 250 },
    { field: "amount", headerName: "Amount", width: 140 },
    { field: "status", headerName: "Status", width: 120 },
    { field: "created", headerName: "Created", width: 180 },
    {
      field: "action",
      headerName: "Action",
      width: 220,
      renderCell: (params) => (
        <>
          <Edit
            className="cursor-pointer text-blue-500 hover:text-blue-700"
            onClick={() => openModal(params.row)}
          />
          <Delete
            className="cursor-pointer text-red-500 hover:text-red-700 ml-2"
            onClick={() => handleDelete(params.row.id)}
          />
          <Visibility
            className="cursor-pointer text-green-500 hover:text-green-700 ml-2"
            onClick={() => openModal(params.row)}
          />
        </>
      ),
    },
  ];

  return (
    <>
      <Topbar />
      <div className="flex">
        <Sidebar />
        <div style={{ width: "80%" }} className="h-full">
          <h1 className="text-3xl my-8 mx-4 sm:text-xl">Manage Invoice</h1>
          <DataGrid
            rows={invoices}
            columns={columns}
            pageSize={5}
            rowsPerPageOptions={[5, 10, 20]}
            checkboxSelection
            disableSelectionOnClick
          />
        </div>
      </div>
      <Modal
        isOpen={modalIsOpen}
        onRequestClose={closeModal}
        contentLabel="Invoice Details"
      >
        <div className="text-center">
          <h2 className="text-2xl font-bold mb-4">Invoice Details</h2>
          {selectedInvoice && (
            <div className="text-left">
              <p className="mb-2"><strong>ID:</strong> {selectedInvoice.id}</p>
              <input
                type="text"
                value={editedInvoice.customer}
                onChange={(e) => handleFieldChange(e, "customer")}
                placeholder="Customer"
                className="border rounded-md px-2 py-1 mb-2"
              />
              <input
                type="text"
                value={editedInvoice.email}
                onChange={(e) => handleFieldChange(e, "email")}
                placeholder="Email"
                className="border rounded-md px-2 py-1 mb-2"
              />
              <input
                type="text"
                value={editedInvoice.amount}
                onChange={(e) => handleFieldChange(e, "amount")}
                placeholder="Amount"
                className="border rounded-md px-2 py-1 mb-2"
              />
              <input
                type="text"
                value={editedInvoice.status}
                onChange={(e) => handleFieldChange(e, "status")}
                placeholder="Status"
                className="border rounded-md px-2 py-1 mb-2"
              />
              <input
                type="text"
                value={editedInvoice.created}
                onChange={(e) => handleFieldChange(e, "created")}
                placeholder="Created"
                className="border rounded-md px-2 py-1 mb-2"
              />
              <button
                className="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg mr-2"
                onClick={handleSaveEdit}
              >
                Apply Changes
              </button>
              <button
                className="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg"
                onClick={closeModal}
              >
                Cancel
              </button>
            </div>
          )}
        </div>
      </Modal>
    </>
  );
}
