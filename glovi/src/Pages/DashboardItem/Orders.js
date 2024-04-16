import "./productList.css";
import { DataGrid } from "@mui/x-data-grid";
import { DeleteOutline } from "@mui/icons-material";
import { Link } from "react-router-dom";
import { useState, useEffect } from "react";
import Topbar from "../DashboardItem/AdminComponents/topbar/Topbar";
import Sidebar from "../DashboardItem/AdminComponents/sidebar/Sidebar";

export default function OrdersList() {
  const [orders, setOrders] = useState([]);

  useEffect(() => {
    // Use sample data for demonstration
    setOrders([
      {
        _id: 1,
        orderNo: 12312,
        product: 'Shipment for - Glovi-2760352186',
        customer: 'Shivam Verma',
        createdAt: '2023-12-11T12:34:56',
        amount: 12,
        orderStatus: 'shipped',
        payment_method: 'Visa',
        payment_status: 'paid'
      },
      {
        _id: 2,
        orderNo: 12312,
        product: 'Shipment for - Glovi-2760352186',
        customer: 'Milenna',
        createdAt: '2023-12-11T12:34:56',
        amount: 120,
        orderStatus: 'shipped',
        payment_method: 'Visa',
        payment_status: 'paid'
      },
      {
        _id: 3,
        orderNo: 12312,
        product: 'Shipment for - Glovi-2760352186',
        customer: 'Harsh Arora',
        createdAt: '2023-12-11T12:34:56',
        amount: 12,
        orderStatus: 'shipped',
        payment_method: 'Visa',
        payment_status: 'paid'
      }
    ]);
  }, []);

  const handleDelete = (id) => {
    setOrders(orders.filter(order => order._id !== id));
  };

  function timeCellRenderer(params) {
    const date = new Date(params.value).toLocaleDateString();
    const time = new Date(params.value).toLocaleTimeString();
    const statusText = date + ' ' + time;
    return <div>{statusText}</div>;
  }

  const columns = [
    { field: "orderNo", headerName: "Order ID", width: 100 },
    { field: "createdAt", headerName: "Created", width: 120, renderCell: timeCellRenderer },
    { field: "product", headerName: "Product", width: 160 },
    { field: "customer", headerName: "Customer", width: 160 },
    { field: "amount", headerName: "Amount", width: 120 },
    { field: "orderStatus", headerName: "Order Status", width: 120 },
    { field: "payment_method", headerName: "Payment Method", width: 120 },
    { field: "payment_status", headerName: "Payment Status", width: 120 },
    {
      field: "action",
      headerName: "Action",
      width: 150,
      renderCell: (params) => (
        <>
          <Link to={`/CurrentOrder/${params.row.username}/${params.row.orderNo}`}>
            <button className="productListEdit">Respond</button>
          </Link>
          <DeleteOutline className="productListDelete" onClick={() => handleDelete(params.row._id)} />
        </>
      ),
    },
  ];

  return (
    <>
      <Topbar />
      <div className="flex justify-between">
        <Sidebar />
        <div style={{width: "80%"}} className="h-full">
          <h1 className="text-3xl my-8 mx-4">Orders</h1>
          <DataGrid
            rows={orders}
            disableSelectionOnClick
            columns={columns}
            pageSize={8}
            checkboxSelection
            getRowId={(row) => row._id}
          />
        </div>
      </div>
    </>
  );
}
