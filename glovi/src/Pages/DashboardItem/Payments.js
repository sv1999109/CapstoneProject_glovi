import { DataGrid } from "@mui/x-data-grid";
import { Edit, Delete, Visibility } from "@mui/icons-material";
import { useState } from "react";
import Modal from 'react-modal';
import Topbar from "../DashboardItem/AdminComponents/topbar/Topbar";
import Sidebar from "../DashboardItem/AdminComponents/sidebar/Sidebar";

export default function Payments() {
  const [invoices, setInvoices] = useState([
    {
      id: 1,
      reference: "INV12345",
      invoice: "INV-2024-001",
      customer: "John Doe",
      amount: "$500",
      status: "Paid",
      paymentMethod: "Credit Card",
      date: "2024-04-15",
    },
    {
      id: 2,
      reference: "INV67890",
      invoice: "INV-2024-002",
      customer: "Jane Smith",
      amount: "$750",
      status: "Pending",
      paymentMethod: "PayPal",
      date: "2024-04-14",
    },
  ]);

  const [modalIsOpen, setModalIsOpen] = useState(false);
  const [selectedInvoice, setSelectedInvoice] = useState(null);

  const openModal = (invoice) => {
    setSelectedInvoice(invoice);
    setModalIsOpen(true);
  };

  const closeModal = () => {
    setSelectedInvoice(null);
    setModalIsOpen(false);
  };

  const handleEdit = (id, newData) => {
    const updatedInvoices = invoices.map(invoice => {
      if (invoice.id === id) {
        return { ...invoice, ...newData };
      }
      return invoice;
    });
    setInvoices(updatedInvoices);
    closeModal();
  };

  const handleDelete = (id) => {
    const updatedInvoices = invoices.filter(invoice => invoice.id !== id);
    setInvoices(updatedInvoices);
    closeModal();
  };

  const modalStyle = {
    content: {
      top: '50%',
      left: '50%',
      right: 'auto',
      bottom: 'auto',
      marginRight: '-50%',
      transform: 'translate(-50%, -50%)',
      padding: '40px',
      border: 'none',
      boxShadow: '0 4px 8px rgba(0, 0, 0, 0.1)',
      borderRadius: '8px',
      backgroundColor: '#fff',
      maxWidth: '400px',
      width: '90%',
    },
    overlay: {
      backgroundColor: 'rgba(0, 0, 0, 0.5)',
      zIndex: '1000',
    },
  };

  
  const columns = [
    { field: "reference", headerName: "Reference", width: 150 },
    { field: "invoice", headerName: "Invoice", width: 150 },
    { field: "customer", headerName: "Customer", width: 150 },
    { field: "amount", headerName: "Amount", width: 120 },
    { field: "status", headerName: "Status", width: 120 },
    { field: "paymentMethod", headerName: "Payment Method", width: 150 },
    { field: "date", headerName: "Date", width: 120 },
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
        <div style={{width: "80%"}} className="h-full">
        <h1 className="text-3xl my-8 mx-4">Payments</h1>
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
        style={modalStyle}
        contentLabel="Invoice Details"
      >
        <div className="text-center">
          <h2 className="text-2xl font-bold mb-4">Invoice Details</h2>
          {selectedInvoice && (
            <div className="text-left">
              <p className="mb-2"><strong>Reference:</strong> {selectedInvoice.reference}</p>
              <p className="mb-2"><strong>Invoice:</strong> {selectedInvoice.invoice}</p>
              <p className="mb-2"><strong>Customer:</strong> {selectedInvoice.customer}</p>
              <p className="mb-2"><strong>Amount:</strong> {selectedInvoice.amount}</p>
              <p className="mb-2"><strong>Status:</strong> {selectedInvoice.status}</p>
              <p className="mb-2"><strong>Payment Method:</strong> {selectedInvoice.paymentMethod}</p>
              <p className="mb-2"><strong>Date:</strong> {selectedInvoice.date}</p>
            </div>
          )}
          <button className="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300" onClick={closeModal}>Close</button>
        </div>
      </Modal>
    </>
  );
}
