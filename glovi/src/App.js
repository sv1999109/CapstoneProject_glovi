import { BrowserRouter,Routes,Route } from "react-router-dom";  
import React from "react";
import "./AppStyle.css"
import Login from "./Pages/Login/Login.js";
import Sidebar from '../src/Pages/DashboardItem/AdminComponents/sidebar/Sidebar.js'
import Signup from "./Pages/SignUp/Signup.js";
import Homepage from "./Pages/HomePage/Homepage.js";
import Pallet from "./Pages/Services/PalletShippingService.js";
import Container from "./Pages/Services/ContainerShippingService.js";
import Truck from "./Pages/Services/TruckTransportService.js";
import Van from "./Pages/Services/VanTransportService.js";
import Parcel from "./Pages/Services/ParcelDelivery.js";
import Documents from "./Pages/Services/DocumentsShippingService.js";
import Support from "./Pages/Support/Support.js";
import About from "./Pages/AboutUs/AboutUs.js";
import Blogs from "./Pages/Blogs/Blogs.js";
import FAQ from "./Pages/Faq/FAQ.js";
import Shipping from "./Pages/Shipping/Shipping.js";
import GetEstimate from "./Pages/GetEstimate/GetEstimate.js";
import AddressBook from "./Pages/DashboardItem/AddressBook.js";
import AddAddress from "./Pages/DashboardItem/AddAddress.js";
import ManageInvoice from "./Pages/DashboardItem/ManageInvoice.js";
import Orders from "./Pages/DashboardItem/Orders.js";
import Payments from "./Pages/DashboardItem/Payments.js";
import Home from "../src/Pages/DashboardItem/AdminPages/home/Home.js";
import CreateShipmentPage from "../src/Pages/DashboardItem/AdminPages/Shipment/CreateShipmentPage.js";
import ManageShipments from "../src/Pages/DashboardItem/ManageShipments.js";
import Tracking from "../src/Pages/Tracking/Tracking.js";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Homepage />}/>
        <Route path="/login" element={<Login />}/>
        <Route path="/Signup" element={<Signup />}/>
        <Route path="/PalletService" element={<Pallet />}/>
        <Route path="/ContainerService" element={<Container />}/>
        <Route path="/TruckService" element={<Truck />}/>
        <Route path="/VanService" element={<Van />}/>
        <Route path="/ParcelService" element={<Parcel />}/>
        <Route path="/DocumentsService" element={<Documents />}/>
        <Route path="/Support" element={<Support />}/>
        <Route path="/AboutUs" element={<About />}/>
        <Route path="/Blogs" element={<Blogs />}/>
        <Route path="/FAQ" element={<FAQ />}/>
        <Route path="/Shipping" element={<Shipping />}/>
        <Route path="/GetEstimate" element={<GetEstimate />}/>
        <Route path="/Dashboard"element={<Home/>}/>
        <Route path="/createShipment"element={<CreateShipmentPage/>}/>
        <Route path="/AddressBook" element={<AddressBook />}/>
        <Route path="/manageShipments" element={<ManageShipments />}/>
        <Route path="/ManageInvoice" element={<ManageInvoice />}/>
        <Route path="/Orders" element={<Orders />}/>
        <Route path="/Payments" element={<Payments />}/>
        <Route path="/Tracking" element={<Tracking />}/>
        <Route path="/AddAddress" element={<AddAddress />}/>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
