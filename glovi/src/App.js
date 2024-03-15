import { BrowserRouter,Routes,Route } from "react-router-dom";  
import React from "react";
import "./AppStyle.css"
import Login from "./Pages/LoginSignup";
import Home from "./Pages/Home";
import Pallet from "./Pages/PalletShippingService.js";
import Container from "./Pages/ContainerShippingService.js";
import Truck from "./Pages/TruckTransportService.js";
import Van from "./Pages/VanTransportService.js";
import Parcel from "./Pages/ParcelDelivery.js";
import Documents from "./Pages/DocumentsShippingService.js";
import Support from "./Pages/Support.js";
import About from "./Pages/AboutUs.js";
import Blogs from "./Pages/Blogs.js";
import FAQ from "./Pages/FAQ.js";
import PalletStacking from "./Pages/PalletStacking.js";
import MasteringtheArt from "./Pages/MasteringtheArt.js";
import UnderstandingProhibitedItems from "./Pages/UnderstandingProhibitedItems.js";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />}/>
        <Route path="/login" element={<Login />}/>
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
      </Routes>
    </BrowserRouter>
  );
}

export default App;
