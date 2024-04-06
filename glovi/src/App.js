import { BrowserRouter,Routes,Route } from "react-router-dom";  
import React from "react";
import "./AppStyle.css"
import Login from "./Pages/Login/Login.js";
import Signup from "./Pages/SignUp/Signup.js";
import Homepage from "./Pages/HomePage/Homepage.jsx";
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
import PalletStacking from "./Pages/BlogsItems/PalletStacking.js";
import MasteringtheArt from "./Pages/BlogsItems/MasteringtheArt.js";
import UnderstandingProhibitedItems from "./Pages/BlogsItems/UnderstandingProhibitedItems.js";
import Shipping from "./Pages/Shipping/Shipping.js";
import GetEstimate from "./Pages/GetEstimate/GetEstimate.js";
import Dashboard from "./Components/Dashboard/DasboardNav.js";

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
        <Route path="/PalletStacking" element={<PalletStacking />}/>
        <Route path="/MasteringtheArt" element={<MasteringtheArt />}/>
        <Route path="/UnderstandingProhibitedItems" element={<UnderstandingProhibitedItems />}/>
        <Route path="/Shipping" element={<Shipping />}/>
        <Route path="/GetEstimate" element={<GetEstimate />}/>
        <Route path="/Dashboard" element={<Dashboard />}/>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
