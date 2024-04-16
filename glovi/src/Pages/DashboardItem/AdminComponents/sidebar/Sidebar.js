import React, { useEffect, useState } from "react";
import {
  Dashboard,
  LocationOn,
  MonetizationOn,
  AssignmentInd,
  Payment,
  LocalShipping,
  Mail,
} from "@mui/icons-material";
import { Link } from "react-router-dom";

export default function Sidebar() {
  const [isMobile, setIsMobile] = useState(false);
  const [sidebarHeight, setSidebarHeight] = useState();

  useEffect(() => {
    function handleResize() {
      setIsMobile(window.innerWidth <= 768);
      adjustSidebarHeight();
    }

    function adjustSidebarHeight() {
      if (window.innerWidth <= 620) {
        setSidebarHeight("1566px");
      } else {
        setSidebarHeight("917px");
      }
    }

    window.addEventListener("resize", handleResize);
    handleResize();

    return () => {
      window.removeEventListener("resize", handleResize);
    };
  }, []);


  return (
    <aside
      style={{
        backgroundColor: "rgb(33 12 45)",
        boxShadow:
          "rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset",
        height: sidebarHeight,
        width: isMobile ? "80px" : "300px",
        transition: "width 0.3s ease",
      }}
      className="flex-shrink-0"
    >
      <div className="flex flex-col">
        <div className="flex flex-col items-center justify-center p-4">
          {!isMobile && (
            <>
              <img
                src="https://ui-avatars.com/api/?name=Admin"
                className="w-36 h-36 rounded-full bg-gray-400 mb-2"
                alt="Admin Avatar"
              />
              <div className="text-white font-medium text-lg">Admin</div>
            </>
          )}
        </div>

        <div className="flex-1 px-4 py-4 space-y-2 relative">
          <Link
            to="/dashboard"
            className="block p-2 text-sm font-medium text-white rounded-md hover:bg-gray-100 hover:text-gray-800"
          >
            <Dashboard className="mr-3 text-gray-400" />
            {!isMobile && "Dashboard"}
          </Link>
          <Link
            to="/AddressBook"
            className="block p-2 text-sm font-medium text-white rounded-md hover:bg-gray-100 hover:text-gray-800"
          >
            <LocationOn className="mr-3 text-gray-400" />
            {!isMobile && "Address Book"}
          </Link>
          <Link
            to="/orders"
            className="block p-2 text-sm font-medium text-white rounded-md hover:bg-gray-100 hover:text-gray-800"
          >
            <MonetizationOn className="mr-3 text-gray-400" />
            {!isMobile && "Orders"}
          </Link>
          <Link
            to="/ManageInvoice"
            className="block p-2 text-sm font-medium text-white rounded-md hover:bg-gray-100 hover:text-gray-800"
          >
            <AssignmentInd className="mr-3 text-gray-400" />
            {!isMobile && "Manage Invoice"}
          </Link>
          <Link
            to="/Payments"
            className="block p-2 text-sm font-medium text-white rounded-md hover:bg-gray-100 hover:text-gray-800"
          >
            <Payment className="mr-3 text-gray-400" />
            {!isMobile && "Payments"}
          </Link>
          <Link
            to="/createShipment"
            className="block p-2 text-sm font-medium text-white rounded-md hover:bg-gray-100 hover:text-gray-800"
          >
            <LocalShipping className="mr-3 text-gray-400" />
            {!isMobile && "Create Shipment"}
          </Link>
          <Link
            to="/manageShipments"
            className="block p-2 text-sm font-medium text-white rounded-md hover:bg-gray-100 hover:text-gray-800"
          >
            <Mail className="mr-3 text-gray-400" />
            {!isMobile && "Manage Shipments"}
          </Link>
        </div>
      </div>
    </aside>
  );
}
