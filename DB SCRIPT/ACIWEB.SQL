-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2018 at 05:14 PM
-- Server version: 5.5.54-38.7-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daoutqw3_suarez`
--

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Sales_Header_Imp`;
CREATE TABLE `Sales_Header_Imp` (
  `ID_compania` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `InvoiceNumber` varchar(20) NOT NULL DEFAULT '',
  `CustomerID` varchar(50) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `Subtotal` decimal(18,4) NOT NULL,
  `TaxID` varchar(20) NOT NULL,
  `Net_due` decimal(18,4) NOT NULL,
  `Export_date` datetime DEFAULT NULL,
  `Enviado` tinyint(4) DEFAULT '0',
  `Error` tinyint(4) DEFAULT '0',
  `ErrorPT` varchar(1024) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `DueDate` datetime DEFAULT NULL,
  `saletax` int(11) NOT NULL,
  `OrderTax` decimal(18,4) DEFAULT NULL,
  `SalesRepID` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Table structure for table `CompanyLogSync`
--

DROP TABLE IF EXISTS `CompanyLogSync`;
CREATE TABLE `CompanyLogSync` (
  `ID_compania` int(11) NOT NULL,
  `CompanyNameSage50` varchar(39) DEFAULT NULL,
  `LastSync` datetime DEFAULT NULL,
  `Directory` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CompanySession`
--

DROP TABLE IF EXISTS `CompanySession`;
CREATE TABLE `CompanySession` (
  `ID_compania` bigint(20) NOT NULL,
  `CompanyNameSage50` varchar(50) NOT NULL,
  `isConnected` tinyint(1) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CompanySession`
--

INSERT INTO `CompanySession` (`ID_compania`, `CompanyNameSage50`, `isConnected`, `LAST_CHANGE`) VALUES
(0, 'INITIAL', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

DROP TABLE IF EXISTS `company_info`;
CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `id_company_sage` int(11) DEFAULT NULL,
  `Tel` varchar(45) DEFAULT NULL,
  `Fax` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `Sage_Conn` int(11) DEFAULT '0',
  `lang` varchar(2) NOT NULL DEFAULT 'es'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `company_name`, `address`, `id_company_sage`, `Tel`, `Fax`, `email`, `Sage_Conn`, `lang`) VALUES
(1, 'Test Company', NULL, NULL, NULL, NULL, NULL, 0, 'es');

-- --------------------------------------------------------

--
-- Table structure for table `CONF_NC_MOTIVO`
--

DROP TABLE IF EXISTS `CONF_NC_MOTIVO`;
CREATE TABLE `CONF_NC_MOTIVO` (
  `ID` int(11) NOT NULL,
  `DESCRIPTION` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CONF_SMTP`
--

DROP TABLE IF EXISTS `CONF_SMTP`;
CREATE TABLE `CONF_SMTP` (
  `ID` int(11) NOT NULL,
  `HOSTNAME` varchar(150) NOT NULL,
  `PORT` int(3) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `Auth` varchar(5) NOT NULL DEFAULT 'true',
  `SMTPSecure` varchar(10) NOT NULL DEFAULT 'false',
  `SMTPDebug` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CONF_SMTP`
--

INSERT INTO `CONF_SMTP` (`ID`, `HOSTNAME`, `PORT`, `USERNAME`, `PASSWORD`, `Auth`, `SMTPSecure`, `SMTPDebug`) VALUES
(1, 'aciweb-pa.com', 465, 'info@aciweb-pa.com', 'admin123$', 'true', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `CON_HEADER`
--

DROP TABLE IF EXISTS `CON_HEADER`;
CREATE TABLE `CON_HEADER` (
  `date` date NOT NULL,
  `idReg` int(11) NOT NULL,
  `idJob` varchar(40) NOT NULL,
  `idPha` varchar(40) NOT NULL,
  `idCost` varchar(40) NOT NULL,
  `lastChange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nota` varchar(255) DEFAULT NULL,
  `refReg` varchar(7) NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CON_REG_TRAS`
--

DROP TABLE IF EXISTS `CON_REG_TRAS`;
CREATE TABLE `CON_REG_TRAS` (
  `ID` int(11) NOT NULL,
  `idReg` int(11) NOT NULL,
  `idRegTras` int(11) NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CREDITNOTE_DETAIL`
--

DROP TABLE IF EXISTS `CREDITNOTE_DETAIL`;
CREATE TABLE `CREDITNOTE_DETAIL` (
  `ID` int(11) NOT NULL,
  `ID_compania` bigint(20) NOT NULL,
  `CreditNoteNumber` varchar(20) NOT NULL,
  `ItemOrd` int(11) NOT NULL,
  `Item_id` varchar(20) NOT NULL,
  `Description` varchar(160) NOT NULL,
  `Quantity` decimal(11,5) NOT NULL,
  `Unit_Price` decimal(18,4) NOT NULL,
  `Net_line` decimal(18,4) NOT NULL,
  `Taxable` int(1) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `REMARK` varchar(200) DEFAULT NULL,
  `PK_CHICO` varchar(50) DEFAULT NULL,
  `PK_GRANDE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CREDITNOTE_HEADER`
--

DROP TABLE IF EXISTS `CREDITNOTE_HEADER`;
CREATE TABLE `CREDITNOTE_HEADER` (
  `ID_compania` bigint(20) NOT NULL,
  `CreditNoteNumber` varchar(20) NOT NULL,
  `GenCreditNumber` varchar(50) DEFAULT NULL,
  `CustomerID` varchar(50) NOT NULL,
  `CustomerPO` varchar(20) DEFAULT NULL,
  `CustomerName` varchar(39) NOT NULL,
  `Subtotal` decimal(18,4) NOT NULL,
  `TaxID` varchar(8) NOT NULL,
  `OrderTax` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `Net_due` decimal(18,4) NOT NULL,
  `Export_date` varchar(50) DEFAULT NULL,
  `Enviado` tinyint(1) NOT NULL DEFAULT '0',
  `Error` tinyint(1) DEFAULT '0',
  `ErrorPT` varchar(1024) DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `saletax` int(11) NOT NULL,
  `tipo_licitacion` varchar(30) DEFAULT NULL,
  `entrega` varchar(30) DEFAULT NULL,
  `termino_pago` varchar(30) DEFAULT NULL,
  `Columna 33` int(11) DEFAULT NULL,
  `InvoiceNumber` varchar(50) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `ShipToName` varchar(39) DEFAULT NULL,
  `ShipToAddressLine1` varchar(30) DEFAULT NULL,
  `ShipToAddressLine2` varchar(30) DEFAULT NULL,
  `ShipToCity` varchar(20) DEFAULT NULL,
  `ShipToState` varchar(2) DEFAULT NULL,
  `ShipToZip` varchar(12) DEFAULT NULL,
  `ShipToCountry` varchar(15) DEFAULT NULL,
  `Emitida` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_entrega` varchar(20) DEFAULT NULL,
  `TipoPago` int(11) DEFAULT '3',
  `printer` varchar(50) DEFAULT '3',
  `motivo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CTA_GL_CONF`
--

DROP TABLE IF EXISTS `CTA_GL_CONF`;
CREATE TABLE `CTA_GL_CONF` (
  `ID` int(11) NOT NULL,
  `CTA_DEV` varchar(20) NOT NULL,
  `CTA_CXC` varchar(20) NOT NULL,
  `CTA_CXP` varchar(20) NOT NULL,
  `CTA_PUR` varchar(20) NOT NULL,
  `CTA_TAX` varchar(20) NOT NULL,
  `GLACCT` varchar(20) NOT NULL,
  `GL_RETEN` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `Customers_Exp`
--

DROP TABLE IF EXISTS `Customers_Exp`;
CREATE TABLE `Customers_Exp` (
  `ID` int(11) NOT NULL,
  `CustomerID` varchar(20) NOT NULL,
  `Customer_Bill_Name` varchar(39) NOT NULL,
  `PriceLevel` int(11) NOT NULL,
  `Phone_Number` varchar(20) NOT NULL,
  `Contact` varchar(45) NOT NULL,
  `Balance` decimal(10,2) NOT NULL,
  `CreditLimit` decimal(10,2) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `AddressLine1` varchar(30) NOT NULL,
  `AddressLine2` varchar(30) NOT NULL,
  `City` varchar(20) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` varchar(12) NOT NULL,
  `Country` varchar(15) NOT NULL,
  `IsActive` bit(1) NOT NULL,
  `SalesRepID` varchar(20) NOT NULL,
  `SalesRepName` varchar(56) NOT NULL,
  `id_compania` int(11) NOT NULL,
  `custom_field1` varchar(40) NOT NULL,
  `custom_field2` varchar(40) NOT NULL,
  `Custom_field3` varchar(40) NOT NULL,
  `Custom_field4` varchar(40) NOT NULL,
  `Custom_field5` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Customers_Imp`
--

DROP TABLE IF EXISTS `Customers_Imp`;
CREATE TABLE `Customers_Imp` (
  `ID_compania` bigint(20) DEFAULT NULL,
  `CustomerID` varchar(20) DEFAULT NULL,
  `Customer_Bill_Name` varchar(39) DEFAULT NULL,
  `AddressLine1` varchar(30) DEFAULT NULL,
  `AddressLine2` varchar(30) DEFAULT NULL,
  `City` varchar(20) DEFAULT NULL,
  `State` varchar(2) DEFAULT NULL,
  `Zip` varchar(12) DEFAULT NULL,
  `Country` varchar(15) DEFAULT NULL,
  `Telephone1` varchar(20) DEFAULT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `Custom_field1` varchar(40) DEFAULT NULL,
  `Custom_field2` varchar(40) DEFAULT NULL,
  `Custom_field3` varchar(40) DEFAULT NULL,
  `Custom_field4` varchar(40) DEFAULT NULL,
  `Custom_field5` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Customer_Credit_Memo_Detail_Imp`
--

DROP TABLE IF EXISTS `Customer_Credit_Memo_Detail_Imp`;
CREATE TABLE `Customer_Credit_Memo_Detail_Imp` (
  `DetailID` int(11) NOT NULL,
  `TransactionID` varchar(20) NOT NULL,
  `ID_compania` int(11) NOT NULL DEFAULT '0',
  `Item_id` varchar(20) DEFAULT NULL,
  `Description` varchar(160) DEFAULT NULL,
  `GL_Acct` varchar(15) DEFAULT NULL,
  `Quantity` decimal(11,4) NOT NULL,
  `Unit_Price` decimal(16,2) NOT NULL,
  `Net_line` decimal(16,2) NOT NULL,
  `JobID` int(20) DEFAULT NULL,
  `JobPhaseID` int(20) DEFAULT NULL,
  `JobCostCodeID` int(20) DEFAULT NULL,
  `Tax_Type` int(1) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Customer_Credit_Memo_Header_Imp`
--

DROP TABLE IF EXISTS `Customer_Credit_Memo_Header_Imp`;
CREATE TABLE `Customer_Credit_Memo_Header_Imp` (
  `TransactionID` bigint(20) NOT NULL,
  `ID_compania` int(11) NOT NULL,
  `CreditNumber` varchar(20) NOT NULL,
  `CustomerID` varchar(20) NOT NULL,
  `CustomerName` varchar(39) NOT NULL,
  `Date` datetime NOT NULL,
  `AR_Account` varchar(15) DEFAULT NULL,
  `TaxID` varchar(8) NOT NULL,
  `Subtotal` decimal(16,2) NOT NULL,
  `Net_Credit_due` decimal(16,2) NOT NULL,
  `Export_date` datetime DEFAULT NULL,
  `Enviado` tinyint(2) DEFAULT '0',
  `Error` tinyint(2) DEFAULT '0',
  `ErrorPT` varchar(1024) DEFAULT NULL,
  `LAST_CHANGE` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `USER` int(11) NOT NULL,
  `CreditNoteNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CUST_PAY_TERM`
--

DROP TABLE IF EXISTS `CUST_PAY_TERM`;
CREATE TABLE `CUST_PAY_TERM` (
  `TermID` int(11) NOT NULL,
  `DaysToPay` varchar(50) DEFAULT NULL,
  `TIPO` int(11) DEFAULT '0',
  `ID_compania` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `FAC_DET_CONF`
--

DROP TABLE IF EXISTS `FAC_DET_CONF`;
CREATE TABLE `FAC_DET_CONF` (
  `NO_LINES` int(4) NOT NULL,
  `CUSTOM_FIELD` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `ITEMS_FILTER` varchar(2048) DEFAULT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `InventoryAdjust_Imp`
--

DROP TABLE IF EXISTS `InventoryAdjust_Imp`;
CREATE TABLE `InventoryAdjust_Imp` (
  `ItemID` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `JobPhaseID` varchar(20) DEFAULT NULL,
  `JobCostCodeID` varchar(20) DEFAULT NULL,
  `ID_compania` bigint(20) NOT NULL,
  `UniqueInvAdjID` bigint(20) NOT NULL,
  `Reference` varchar(20) NOT NULL,
  `Export_date` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `ReasonToAdjust` varchar(35) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `Account` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `UnitCost` decimal(16,4) DEFAULT NULL,
  `Quantity` decimal(11,4) DEFAULT NULL,
  `ErrorPT` varchar(1024) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `Error` tinyint(1) NOT NULL DEFAULT '0',
  `Enviado` tinyint(1) DEFAULT '0',
  `LAST_CHANGE` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Date` date DEFAULT NULL,
  `USER` int(11) DEFAULT NULL,
  `JobID` varchar(50) DEFAULT NULL,
  `Job_id_int` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `INVOICE_GEN_DETAIL`
--

DROP TABLE IF EXISTS `INVOICE_GEN_DETAIL`;
CREATE TABLE `INVOICE_GEN_DETAIL` (
  `SalesOrderNumber` varchar(50) NOT NULL,
  `ItemOrd` int(11) NOT NULL,
  `Despachado` decimal(16,8) NOT NULL,
  `TotalLinea` decimal(16,2) NOT NULL,
  `ID_compania` int(11) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UnitPrice` decimal(16,2) NOT NULL,
  `ItemID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `INVOICE_GEN_HEADER`
--

DROP TABLE IF EXISTS `INVOICE_GEN_HEADER`;
CREATE TABLE `INVOICE_GEN_HEADER` (
  `InvoiceNumber` varchar(50) DEFAULT NULL,
  `SalesOrderNumber` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `Total` decimal(16,2) NOT NULL,
  `NOTAS` varchar(1024) DEFAULT NULL,
  `SubTotal` decimal(16,2) NOT NULL,
  `Itbms` decimal(16,2) NOT NULL,
  `ID_compania` int(11) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TipoPago` int(11) NOT NULL DEFAULT '3',
  `TaxID` varchar(8) NOT NULL,
  `ID` int(11) NOT NULL,
  `printer` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `INV_PRINT_CONF`
--

DROP TABLE IF EXISTS `INV_PRINT_CONF`;
CREATE TABLE `INV_PRINT_CONF` (
  `SERIAL` varchar(20) NOT NULL,
  `DESCRIPCION` varchar(20) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ITEMS_NO_LOTES`
--

DROP TABLE IF EXISTS `ITEMS_NO_LOTES`;
CREATE TABLE `ITEMS_NO_LOTES` (
  `ID` int(11) NOT NULL,
  `ProductID` varchar(50) NOT NULL,
  `no_lote` varchar(45) NOT NULL,
  `fecha_ven` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `onoff` tinyint(1) NOT NULL DEFAULT '1',
  `REG_KEY` varchar(255) NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Jobs_Exp`
--

DROP TABLE IF EXISTS `Jobs_Exp`;
CREATE TABLE `Jobs_Exp` (
  `ID_compania` int(11) NOT NULL,
  `JobID` varchar(20) NOT NULL,
  `Description` varchar(30) NOT NULL,
  `JobPhases` tinyint(4) NOT NULL,
  `ID` int(11) NOT NULL,
  `IsActive` int(11) NOT NULL,
  `ID_CompaniaOrigen` int(11) NOT NULL,
  `EstimateExpenses` decimal(18,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `Job_Cost_Codes_Exp`
--

DROP TABLE IF EXISTS `Job_Cost_Codes_Exp`;
CREATE TABLE `Job_Cost_Codes_Exp` (
  `ID_compania` bigint(20) NOT NULL,
  `CostCodeID` varchar(20) NOT NULL,
  `Description` varchar(30) DEFAULT NULL,
  `IsActive` int(11) NOT NULL,
  `ID_CompaniaOrigen` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `Job_Estimates_Exp`
--

DROP TABLE IF EXISTS `Job_Estimates_Exp`;
CREATE TABLE `Job_Estimates_Exp` (
  `ID_compania` int(11) NOT NULL,
  `JobdID` varchar(20) DEFAULT NULL,
  `PhaseID` varchar(20) DEFAULT NULL,
  `CostCodeID` varchar(20) DEFAULT NULL,
  `Units` decimal(16,2) DEFAULT NULL,
  `Expenses` decimal(16,2) DEFAULT NULL,
  `Revenues` decimal(16,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Job_Phases_Exp`
--

DROP TABLE IF EXISTS `Job_Phases_Exp`;
CREATE TABLE `Job_Phases_Exp` (
  `ID_compania` bigint(20) NOT NULL,
  `PhaseID` varchar(20) NOT NULL,
  `Description` varchar(30) NOT NULL,
  `IsActive` int(11) NOT NULL,
  `JobCostCodes` tinyint(4) NOT NULL,
  `ID_CompaniaOrigen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `MOD_MENU_CONF`
--

DROP TABLE IF EXISTS `MOD_MENU_CONF`;
CREATE TABLE `MOD_MENU_CONF` (
  `ID` int(1) NOT NULL,
  `mod_sales` int(1) NOT NULL DEFAULT '0',
  `mod_fact` int(1) NOT NULL DEFAULT '0',
  `mod_invt` int(1) NOT NULL DEFAULT '0',
  `mod_rept` int(1) NOT NULL DEFAULT '0',
  `mod_stock` int(1) NOT NULL DEFAULT '0',
  `mod_pro` int(1) NOT NULL DEFAULT '0',
  `mod_invo` int(1) NOT NULL DEFAULT '0',
  `mod_req` int(1) NOT NULL DEFAULT '0',
  `mod_cust` varchar(45) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `MOD_MENU_CONF`
--

INSERT INTO `MOD_MENU_CONF` (`ID`, `mod_sales`, `mod_fact`, `mod_invt`, `mod_rept`, `mod_stock`, `mod_pro`, `mod_invo`, `mod_req`, `mod_cust`) VALUES
(1, 1, 1, 1, 1, 1, 0, 1, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `PRI_LIST_ID`
--

DROP TABLE IF EXISTS `PRI_LIST_ID`;
CREATE TABLE `PRI_LIST_ID` (
  `ID` int(11) NOT NULL,
  `IDPRICE` varchar(50) CHARACTER SET latin1 NOT NULL,
  `DESCRIPTION` varchar(100) DEFAULT NULL,
  `ID_compania` int(11) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PRI_LIST_ITEM`
--

DROP TABLE IF EXISTS `PRI_LIST_ITEM`;
CREATE TABLE `PRI_LIST_ITEM` (
  `IDPRICE` varchar(50) CHARACTER SET latin1 NOT NULL,
  `IDITEM` varchar(50) CHARACTER SET latin1 NOT NULL,
  `DESCRIPTION` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `PRICE` decimal(18,4) DEFAULT NULL,
  `UNIT` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `ID_compania` int(11) DEFAULT NULL,
  `LAST_CHANGE` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Products_Exp`
--

DROP TABLE IF EXISTS `Products_Exp`;
CREATE TABLE `Products_Exp` (
  `ID` int(11) NOT NULL,
  `ProductID` varchar(45) NOT NULL,
  `Description` varchar(160) DEFAULT NULL,
  `QtyOnHand` decimal(18,5) DEFAULT NULL,
  `Price1` decimal(18,4) DEFAULT NULL,
  `Price2` decimal(18,4) DEFAULT NULL,
  `Price3` decimal(18,4) DEFAULT NULL,
  `Price4` decimal(18,4) DEFAULT NULL,
  `Price5` decimal(18,4) DEFAULT NULL,
  `Price6` decimal(18,4) DEFAULT NULL,
  `Price7` decimal(18,4) DEFAULT NULL,
  `Price8` decimal(18,4) DEFAULT NULL,
  `Price9` decimal(18,4) DEFAULT NULL,
  `Price10` decimal(18,4) DEFAULT NULL,
  `TaxType` int(11) DEFAULT NULL,
  `UnitMeasure` varchar(20) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `ItemClass` bigint(8) DEFAULT NULL,
  `id_compania` int(11) NOT NULL DEFAULT '0',
  `status` varchar(1024) DEFAULT NULL,
  `link_foto` varchar(255) DEFAULT NULL,
  `Custom_field1` varchar(40) DEFAULT NULL,
  `Custom_field2` varchar(40) DEFAULT NULL,
  `Custom_field3` varchar(40) DEFAULT NULL,
  `Custom_field4` varchar(40) DEFAULT NULL,
  `Custom_field5` varchar(40) DEFAULT NULL,
  `UPC_SKU` varchar(20) DEFAULT NULL,
  `GL_Sales_Acct` varchar(15) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LastUnitCost` decimal(16,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Products_Imp`
--

DROP TABLE IF EXISTS `Products_Imp`;
CREATE TABLE `Products_Imp` (
  `ID_compania` bigint(20) NOT NULL,
  `ProductID` varchar(20) NOT NULL,
  `Description` varchar(160) DEFAULT NULL,
  `Price1` decimal(16,4) DEFAULT NULL,
  `Price2` decimal(16,4) DEFAULT NULL,
  `Price3` decimal(16,4) DEFAULT NULL,
  `Price4` decimal(16,4) DEFAULT NULL,
  `Price5` decimal(16,4) DEFAULT NULL,
  `Price6` decimal(16,4) DEFAULT NULL,
  `Price7` decimal(16,4) DEFAULT NULL,
  `Price8` decimal(16,4) DEFAULT NULL,
  `Price9` decimal(16,4) DEFAULT NULL,
  `Price10` decimal(16,4) DEFAULT NULL,
  `TaxType` bigint(20) DEFAULT NULL,
  `Custom_field1` varchar(40) DEFAULT NULL,
  `Custom_field2` varchar(40) DEFAULT NULL,
  `Custom_field3` varchar(40) DEFAULT NULL,
  `Custom_field4` varchar(40) DEFAULT NULL,
  `Custom_field5` varchar(40) DEFAULT NULL,
  `UnitMeasure` varchar(20) DEFAULT NULL,
  `GL_Sales_Acct` varchar(15) DEFAULT NULL,
  `Export_date` datetime DEFAULT NULL,
  `Enviado` tinyint(1) DEFAULT NULL,
  `Error` tinyint(1) DEFAULT NULL,
  `ErrorPT` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Detail_Exp`
--

DROP TABLE IF EXISTS `Purchase_Detail_Exp`;
CREATE TABLE `Purchase_Detail_Exp` (
  `ID_compania` bigint(20) NOT NULL,
  `PurchaseID` bigint(20) NOT NULL,
  `RowIndex` int(11) NOT NULL,
  `Item_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Description` varchar(160) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `GL_AccountID` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Quantity` decimal(11,4) NOT NULL,
  `Unit_Price` decimal(16,4) NOT NULL,
  `NetLine` decimal(16,2) NOT NULL,
  `JobID` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `JobPhaseID` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `JobCostCodeID` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table `Purchase_Detail_Imp`
--

DROP TABLE IF EXISTS `Purchase_Detail_Imp`;
CREATE TABLE `Purchase_Detail_Imp` (
  `ID` int(11) NOT NULL,
  `ID_compania` bigint(20) NOT NULL,
  `TransactionID` bigint(20) NOT NULL,
  `Item_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Description` varchar(160) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `GL_Acct` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Quantity` decimal(11,4) NOT NULL,
  `Unit_Price` decimal(16,4) NOT NULL,
  `Net_line` decimal(16,2) NOT NULL,
  `JobID` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `JobPhaseID` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `JobCostCodeID` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Header_Exp`
--

DROP TABLE IF EXISTS `Purchase_Header_Exp`;
CREATE TABLE `Purchase_Header_Exp` (
  `ID_compania` bigint(20) NOT NULL,
  `PurchaseID` bigint(20) NOT NULL,
  `PurchaseNumber` varchar(20) NOT NULL,
  `VendorID` varchar(20) NOT NULL,
  `DropShip` varchar(20) NOT NULL,
  `DropShipCustomerID` varchar(20) NOT NULL,
  `DropShipCustomerName` varchar(20) NOT NULL,
  `VendorName` varchar(150) NOT NULL,
  `Date` datetime NOT NULL,
  `AccountID` varchar(20) NOT NULL,
  `CustomerSO` varchar(20) NOT NULL,
  `Total` decimal(18,4) NOT NULL,
  `ApplyToPurchaseOrder` tinyint(4) DEFAULT NULL,
  `ApplyToPurOrderNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `Purchase_Header_Imp`
--

DROP TABLE IF EXISTS `Purchase_Header_Imp`;
CREATE TABLE `Purchase_Header_Imp` (
  `TransactionID` bigint(20) NOT NULL,
  `ID_compania` bigint(20) NOT NULL,
  `PurchaseNumber` varchar(20) NOT NULL,
  `VendorID` varchar(20) NOT NULL,
  `VendorName` varchar(39) NOT NULL,
  `AP_Account` varchar(15) NOT NULL,
  `Date` datetime NOT NULL,
  `Subtotal` decimal(16,2) NOT NULL,
  `Net_due` decimal(16,2) NOT NULL,
  `Export_date` datetime NOT NULL,
  `Enviado` tinyint(1) NOT NULL,
  `Error` tinyint(1) NOT NULL,
  `ErrorPT` varchar(1024) NOT NULL,
  `nota` varchar(1024) NOT NULL,
  `USER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de cabecera de transacciones de compra para importar a Sage50';

-- --------------------------------------------------------

--
-- Table structure for table `PurOrdr_Detail_Exp`
--

DROP TABLE IF EXISTS `PurOrdr_Detail_Exp`;
CREATE TABLE `PurOrdr_Detail_Exp` (
  `ID_compania` int(11) NOT NULL,
  `TransactionID` bigint(20) NOT NULL,
  `RowIndex` int(11) NOT NULL,
  `Item_id` varchar(20) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `GL_AccountID` varchar(15) NOT NULL,
  `Quantity` decimal(11,4) NOT NULL,
  `Unit_Price` decimal(16,4) NOT NULL,
  `NetLine` decimal(16,2) NOT NULL,
  `QuantityReceived` decimal(16,4) NOT NULL,
  `JobID` varchar(20) NOT NULL,
  `JobPhaseID` varchar(20) NOT NULL,
  `JobCostCodeID` varchar(20) NOT NULL,
  `ID_CompaniaOrigen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `PurOrdr_Header_Exp`
--

DROP TABLE IF EXISTS `PurOrdr_Header_Exp`;
CREATE TABLE `PurOrdr_Header_Exp` (
  `ID_compania` int(11) NOT NULL,
  `TransactionID` bigint(20) NOT NULL,
  `PurchaseOrderNumber` varchar(20) NOT NULL,
  `VendorID` varchar(20) NOT NULL,
  `VendorName` varchar(150) NOT NULL,
  `Date` datetime NOT NULL,
  `AccountID` varchar(20) NOT NULL,
  `CustomerSO` varchar(20) NOT NULL,
  `Total` decimal(18,4) NOT NULL,
  `PO_Closed` tinyint(1) NOT NULL,
  `DropShip` tinyint(1) NOT NULL,
  `DropShipCustomerID` varchar(20) NOT NULL,
  `DropShipCustomerName` varchar(39) NOT NULL,
  `WorkflowAssignee` varchar(39) NOT NULL,
  `WorkflowNote` varchar(2000) NOT NULL,
  `WorkflowStatusName` varchar(32) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_CompaniaOrigen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Table structure for table `reg_traslado`
--

DROP TABLE IF EXISTS `reg_traslado`;
CREATE TABLE `reg_traslado` (
  `id` int(11) NOT NULL,
  `ID_compania` int(11) NOT NULL,
  `id_almacen_ini` varchar(45) DEFAULT NULL,
  `route_ini` varchar(45) DEFAULT NULL,
  `id_almacen_des` varchar(45) DEFAULT NULL,
  `route_des` varchar(45) DEFAULT NULL,
  `LAST_CHANGE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) DEFAULT NULL,
  `ProductID` varchar(45) DEFAULT NULL,
  `lote` varchar(45) DEFAULT NULL,
  `qty` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reportes_diarios`
--

DROP TABLE IF EXISTS `reportes_diarios`;
CREATE TABLE `reportes_diarios` (
  `ID_compania` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `REP_DETAIL`
--

DROP TABLE IF EXISTS `REP_DETAIL`;
CREATE TABLE `REP_DETAIL` (
  `PO_ID` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PAY_REQ` decimal(18,4) NOT NULL,
  `JOB` varchar(50) NOT NULL,
  `PHASE` varchar(50) NOT NULL,
  `CCOST` varchar(50) NOT NULL,
  `NO_REP` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `REP_HEADER`
--

DROP TABLE IF EXISTS `REP_HEADER`;
CREATE TABLE `REP_HEADER` (
  `ID` int(11) NOT NULL,
  `NO_REP` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ID_compania` int(11) NOT NULL,
  `NOTA` varchar(1024) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `USER` int(11) NOT NULL,
  `DATE` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ST_CLOSED` int(11) DEFAULT '0',
  `PAY_DATE` varchar(10) DEFAULT NULL,
  `PAY_OWNER` int(11) DEFAULT NULL,
  `DESC_CLOSED` varchar(255) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `REQ_DETAIL`
--

DROP TABLE IF EXISTS `REQ_DETAIL`;
CREATE TABLE `REQ_DETAIL` (
  `ProductID` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DESCRIPCION` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `UNIDAD` varchar(4) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `JOB` varchar(50) NOT NULL,
  `PHASE` varchar(50) NOT NULL,
  `CCOST` varchar(50) NOT NULL,
  `NO_REQ` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ITEM_UNIQUE_NO` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `REQ_HEADER`
--

DROP TABLE IF EXISTS `REQ_HEADER`;
CREATE TABLE `REQ_HEADER` (
  `ID` int(11) NOT NULL,
  `NO_REQ` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ID_compania` int(11) NOT NULL,
  `NOTA` varchar(1024) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `USER` int(11) NOT NULL,
  `DATE` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `st_closed` int(11) DEFAULT '0',
  `desc_closed` varchar(255) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `REQ_QUOTA`
--

DROP TABLE IF EXISTS `REQ_QUOTA`;
CREATE TABLE `REQ_QUOTA` (
  `ID` int(11) NOT NULL,
  `NO_REQ` varchar(20) NOT NULL,
  `USER` int(11) NOT NULL,
  `ID_compania` int(11) NOT NULL,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `REQ_RECEPT`
--

DROP TABLE IF EXISTS `REQ_RECEPT`;
CREATE TABLE `REQ_RECEPT` (
  `ID` int(11) NOT NULL,
  `NO_REQ` varchar(20) NOT NULL,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ITEM` varchar(20) NOT NULL,
  `QTY` int(11) NOT NULL,
  `USER` int(11) NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SalesOrder_Detail_Exp`
--

DROP TABLE IF EXISTS `SalesOrder_Detail_Exp`;
CREATE TABLE `SalesOrder_Detail_Exp` (
  `ID` int(11) NOT NULL,
  `ID_compania` bigint(20) NOT NULL,
  `TransactionID` bigint(20) NOT NULL,
  `RowIndex` int(2) NOT NULL,
  `Item_id` varchar(20) NOT NULL,
  `Description` varchar(160) NOT NULL,
  `GL_AccountID` varchar(15) NOT NULL,
  `Quantity` decimal(11,4) NOT NULL,
  `QuantityShipped` decimal(16,4) NOT NULL,
  `Unit_Price` decimal(16,4) NOT NULL,
  `NetLine` decimal(16,2) NOT NULL,
  `JobID` varchar(20) NOT NULL,
  `JobPhaseID` varchar(20) NOT NULL,
  `JobCostCodeID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SalesOrder_Detail_Imp`
--

DROP TABLE IF EXISTS `SalesOrder_Detail_Imp`;
CREATE TABLE `SalesOrder_Detail_Imp` (
  `ID` int(11) NOT NULL,
  `ID_compania` bigint(20) NOT NULL,
  `SalesOrderNumber` varchar(20) NOT NULL,
  `ItemOrd` int(11) NOT NULL,
  `Item_id` varchar(20) NOT NULL,
  `Description` varchar(160) NOT NULL,
  `Quantity` decimal(11,5) NOT NULL,
  `Unit_Price` decimal(18,4) NOT NULL,
  `Net_line` decimal(18,4) NOT NULL,
  `Taxable` int(1) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `REMARK` varchar(200) DEFAULT NULL,
  `PK_CHICO` varchar(50) DEFAULT NULL,
  `PK_GRANDE` varchar(50) DEFAULT NULL,
  `INVOICED` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SalesOrder_Header_Exp`
--

DROP TABLE IF EXISTS `SalesOrder_Header_Exp`;
CREATE TABLE `SalesOrder_Header_Exp` (
  `ID_compania` bigint(20) NOT NULL,
  `TransactionID` bigint(20) NOT NULL,
  `SalesOrderNumber` varchar(20) NOT NULL,
  `CustomerID` varchar(20) NOT NULL,
  `CustomerName` varchar(39) NOT NULL,
  `Date` datetime NOT NULL,
  `Close_SO` tinyint(1) NOT NULL,
  `CustomerPO` varchar(20) NOT NULL,
  `Total` decimal(18,4) NOT NULL,
  `TaxID` varchar(8) NOT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SalesOrder_Header_Imp`
--

DROP TABLE IF EXISTS `SalesOrder_Header_Imp`;
CREATE TABLE `SalesOrder_Header_Imp` (
  `ID_compania` bigint(20) NOT NULL,
  `FUSION` varchar(20) DEFAULT NULL,
  `SalesOrderNumber` varchar(20) NOT NULL,
  `CustomerID` varchar(50) NOT NULL,
  `CustomerPO` varchar(20) DEFAULT NULL,
  `CustomerName` varchar(39) NOT NULL,
  `Subtotal` decimal(18,4) NOT NULL,
  `TaxID` varchar(8) NOT NULL,
  `OrderTax` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `Net_due` decimal(18,4) NOT NULL,
  `Export_date` varchar(50) DEFAULT NULL,
  `Enviado` tinyint(1) NOT NULL DEFAULT '0',
  `Error` tinyint(1) DEFAULT '0',
  `ErrorPT` varchar(1024) DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `LAST_CHANGE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `saletax` int(11) NOT NULL,
  `tipo_licitacion` varchar(30) DEFAULT NULL,
  `entrega` varchar(30) DEFAULT NULL,
  `termino_pago` varchar(30) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `ShipToName` varchar(100) DEFAULT NULL,
  `ShipToAddressLine1` varchar(30) DEFAULT NULL,
  `ShipToAddressLine2` varchar(30) DEFAULT NULL,
  `ShipToCity` varchar(20) DEFAULT NULL,
  `ShipToState` varchar(2) DEFAULT NULL,
  `ShipToZip` varchar(12) DEFAULT NULL,
  `ShipToCountry` varchar(15) DEFAULT NULL,
  `Emitida` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_entrega` varchar(20) DEFAULT NULL,
  `lugar_despacho` varchar(45) DEFAULT NULL,
  `DispachPrinted` int(11) NOT NULL DEFAULT '0',
  `blocked` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Sales_Detail_Imp`
--


--
-- Table structure for table `Sales_Detail_Imp`
--

DROP TABLE IF EXISTS `Sales_Detail_Imp`;
CREATE TABLE `Sales_Detail_Imp` (
  `ID_compania` int(11) NOT NULL DEFAULT '0',
  `InvoiceNumber` varchar(20) NOT NULL,
  `Item_id` varchar(50) DEFAULT NULL,
  `Description` varchar(100) NOT NULL,
  `Quantity` decimal(18,4) NOT NULL,
  `Unit_Price` decimal(18,4) NOT NULL,
  `Net_line` decimal(18,4) NOT NULL,
  `Taxable` int(1) DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `GL_Sales_Acct` varchar(15) DEFAULT NULL,
  `JobID` varchar(20) DEFAULT NULL,
  `JobPhaseID` varchar(20) DEFAULT NULL,
  `JobCostCodeID` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `Sales_Representative_Exp`
--

DROP TABLE IF EXISTS `Sales_Representative_Exp`;
CREATE TABLE `Sales_Representative_Exp` (
  `SalesRepID` varchar(20) NOT NULL,
  `SalesRep_Name` varchar(55) DEFAULT NULL,
  `ID_compania` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_fact_pendding`
--

DROP TABLE IF EXISTS `sale_fact_pendding`;
CREATE TABLE `sale_fact_pendding` (
  `SaleOrderId` int(11) NOT NULL,
  `no_lote` varchar(45) DEFAULT NULL,
  `ProductID` varchar(45) DEFAULT NULL,
  `qty` varchar(45) DEFAULT NULL,
  `status_pendding` tinyint(4) DEFAULT NULL,
  `status_location_id` int(11) DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_pendding`
--

DROP TABLE IF EXISTS `sale_pendding`;
CREATE TABLE `sale_pendding` (
  `SaleOrderId` varchar(50) NOT NULL,
  `no_lote` varchar(45) DEFAULT NULL,
  `ProductID` varchar(45) DEFAULT NULL,
  `qty` varchar(45) DEFAULT NULL,
  `status_pendding` tinyint(4) DEFAULT NULL,
  `status_location_id` int(11) DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL,
  `ID_compania` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sale_tax`
--

DROP TABLE IF EXISTS `sale_tax`;
CREATE TABLE `sale_tax` (
  `id` int(11) NOT NULL,
  `taxid` varchar(10) DEFAULT '1',
  `rate` int(11) DEFAULT '7'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sax_company_sage`
--

DROP TABLE IF EXISTS `sax_company_sage`;
CREATE TABLE `sax_company_sage` (
  `ID` int(11) NOT NULL,
  `id_compania` int(11) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `onoff` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin2;


--
-- Table structure for table `SAX_USER`
--

DROP TABLE IF EXISTS `SAX_USER`;
CREATE TABLE `SAX_USER` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `onoff` int(11) NOT NULL DEFAULT '1',
  `role` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `notif_oc` int(11) NOT NULL DEFAULT '0',
  `notif_fc` int(11) NOT NULL DEFAULT '0',
  `photo` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `role_purc` int(11) DEFAULT NULL,
  `role_fiel` int(11) NOT NULL DEFAULT '0',
  `mod_price` int(11) NOT NULL DEFAULT '0',
  `last_login` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `inv_view` int(11) NOT NULL DEFAULT '0',
  `rep_view` int(11) NOT NULL DEFAULT '0',
  `stoc_view` int(11) NOT NULL DEFAULT '0',
  `pro_addmod` int(11) DEFAULT NULL,
  `tpl_addmod` int(11) DEFAULT NULL,
  `printer` int(11) DEFAULT NULL,
  `closeSO` int(11) DEFAULT '0',
  `amountSO` int(11) DEFAULT '0',
  `Recover_key` varchar(1000) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


--
-- Dumping data for table `SAX_USER`
--

INSERT INTO `SAX_USER` (`id`, `name`, `lastname`, `email`, `pass`, `onoff`, `role`, `notif_oc`, `notif_fc`, `photo`, `role_purc`, `role_fiel`, `mod_price`, `last_login`, `inv_view`, `rep_view`, `stoc_view`, `pro_addmod`, `tpl_addmod`, `printer`, `closeSO`, `amountSO`, `Recover_key`) VALUES
(1, 'ROOT', 'SYSTEM', 'root', '0a4edfd780a145a5759e018837956edb', 1, 'admin', 1, 1, '', 1, 1, 1, '', 1, 1, 1, 0, 0, 0, 1, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `SHIP_INFO`
--

DROP TABLE IF EXISTS `SHIP_INFO`;
CREATE TABLE `SHIP_INFO` (
  `ShipAddress` varchar(20) NOT NULL,
  `ID` int(11) NOT NULL,
  `ID_compania` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `STOCKS`
--

DROP TABLE IF EXISTS `STOCKS`;
CREATE TABLE `STOCKS` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `capacity` varchar(45) DEFAULT NULL,
  `ID_compania` bigint(20) NOT NULL,
  `onoff` varchar(45) DEFAULT '1',
  `description` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `STOCK_ITEMS_LOCATION`
--

DROP TABLE IF EXISTS `STOCK_ITEMS_LOCATION`;
CREATE TABLE `STOCK_ITEMS_LOCATION` (
  `id` bigint(20) NOT NULL,
  `lote` varchar(45) NOT NULL,
  `itemID` varchar(45) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `onoff` int(11) NOT NULL DEFAULT '1',
  `qty` decimal(18,4) DEFAULT NULL,
  `location` varchar(45) NOT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `STOCK_LOCATION`
--

DROP TABLE IF EXISTS `STOCK_LOCATION`;
CREATE TABLE `STOCK_LOCATION` (
  `id` int(11) NOT NULL,
  `location` varchar(45) NOT NULL,
  `stock` int(11) NOT NULL,
  `onoff` int(11) DEFAULT '1',
  `description` varchar(45) DEFAULT NULL,
  `ID_compania` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `UNIT_MES_CONVRT`
--

DROP TABLE IF EXISTS `UNIT_MES_CONVRT`;
CREATE TABLE `UNIT_MES_CONVRT` (
  `ID` int(11) NOT NULL,
  `UNIT` varchar(2) NOT NULL,
  `UNIT_TO_CONVERT` varchar(1) NOT NULL,
  `UNIT_NAME` varchar(3) NOT NULL,
  `FACTOR` decimal(18,6) NOT NULL,
  `ID_compania` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Vendors_Exp`
--

DROP TABLE IF EXISTS `Vendors_Exp`;
CREATE TABLE `Vendors_Exp` (
  `ID_compania` int(11) NOT NULL,
  `VendorID` varchar(20) NOT NULL,
  `Name` varchar(39) DEFAULT NULL,
  `Contact` varchar(20) DEFAULT NULL,
  `Phone_Number1` varchar(20) DEFAULT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `AddressLine1` varchar(30) DEFAULT NULL,
  `AddressLine2` varchar(30) DEFAULT NULL,
  `City` varchar(20) DEFAULT NULL,
  `State` varchar(2) DEFAULT NULL,
  `Zip` varchar(12) DEFAULT NULL,
  `Country` varchar(15) DEFAULT NULL,
  `IsActive` float DEFAULT NULL,
  `Custom_field1` varchar(40) DEFAULT NULL,
  `Custom_field2` varchar(40) DEFAULT NULL,
  `Custom_field3` varchar(40) DEFAULT NULL,
  `Custom_field4` varchar(40) DEFAULT NULL,
  `Custom_field5` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `Vendor_Payment_Detail_Exp`
--

DROP TABLE IF EXISTS `Vendor_Payment_Detail_Exp`;
CREATE TABLE `Vendor_Payment_Detail_Exp` (
  `ID_compania` int(11) NOT NULL,
  `ID_CompaniaOrigen` int(11) NOT NULL,
  `TransactionID` bigint(20) NOT NULL,
  `RowIndex` int(11) NOT NULL,
  `ItemId` varchar(20) DEFAULT NULL,
  `Description` varchar(160) DEFAULT NULL,
  `GL_AccountID` varchar(15) DEFAULT NULL,
  `Quantity` decimal(18,4) DEFAULT NULL,
  `Unit_Price` decimal(18,4) DEFAULT NULL,
  `NetLine` decimal(18,4) DEFAULT NULL,
  `JobID` varchar(20) DEFAULT NULL,
  `JobPhaseID` varchar(20) DEFAULT NULL,
  `JobCostCodeID` varchar(20) DEFAULT NULL,
  `ApplyTo` tinyint(4) DEFAULT NULL,
  `ApplyToInvNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
--
-- Table structure for table `Vendor_Payment_Header_Exp`
--

DROP TABLE IF EXISTS `Vendor_Payment_Header_Exp`;
CREATE TABLE `Vendor_Payment_Header_Exp` (
  `ID_compania` int(11) NOT NULL,
  `ID_CompaniaOrigen` int(11) NOT NULL,
  `TransactionID` bigint(20) NOT NULL,
  `CheckNumber` varchar(20) DEFAULT NULL,
  `VendorID` varchar(20) DEFAULT NULL,
  `VendorName` varchar(39) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `AccountID` varchar(20) DEFAULT NULL,
  `Memo` varchar(1024) DEFAULT NULL,
  `Total` decimal(18,4) DEFAULT NULL,
  `Prepayment` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `INV_EVENT_LOG`
--

DROP TABLE IF EXISTS `INV_EVENT_LOG`;
CREATE TABLE `INV_EVENT_LOG` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` varchar(45) NOT NULL,
  `JobID` varchar(20) NOT NULL,
  `JobPhaseID` varchar(20) DEFAULT NULL,
  `JobCostCodeID` varchar(20) DEFAULT NULL,
  `PurchaseNumber` varchar(20) DEFAULT NULL,
  `PurchaseOrderNumber` varchar(20) DEFAULT NULL,
  `Total` decimal(18,4) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `User` int(11) NOT NULL,
  `ID_compania` int(11) NOT NULL,
   PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `INV_EVENT_LOG`
--

DROP TABLE IF EXISTS `INV_EVENT_LOG`;
CREATE TABLE `INV_EVENT_LOG` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` varchar(45) NOT NULL,
  `JobID` varchar(20) NOT NULL,
  `JobPhaseID` varchar(20) DEFAULT NULL,
  `JobCostCodeID` varchar(20) DEFAULT NULL,
  `PurchaseNumber` varchar(20) DEFAULT NULL,
  `PurchaseOrderNumber` varchar(20) DEFAULT NULL,
  `Total` decimal(18,4) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `User` int(11) NOT NULL,
  `ID_compania` int(11) NOT NULL,
   PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `CompanyLogSync`
--
ALTER TABLE `CompanyLogSync`
  ADD PRIMARY KEY (`ID_compania`);

--
-- Indexes for table `CompanySession`
--
ALTER TABLE `CompanySession`
  ADD PRIMARY KEY (`ID_compania`,`CompanyNameSage50`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`);



--
-- Indexes for table `CONF_NC_MOTIVO`
--
ALTER TABLE `CONF_NC_MOTIVO`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `CONF_SMTP`
--
ALTER TABLE `CONF_SMTP`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `CON_HEADER`
--
ALTER TABLE `CON_HEADER`
  ADD PRIMARY KEY (`idReg`);

--
-- Indexes for table `CON_REG_TRAS`
--
ALTER TABLE `CON_REG_TRAS`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `CREDITNOTE_DETAIL`
--
ALTER TABLE `CREDITNOTE_DETAIL`
  ADD PRIMARY KEY (`ID`,`ID_compania`,`CreditNoteNumber`);

--
-- Indexes for table `CREDITNOTE_HEADER`
--
ALTER TABLE `CREDITNOTE_HEADER`
  ADD PRIMARY KEY (`ID`,`ID_compania`,`CreditNoteNumber`);

--
-- Indexes for table `CTA_GL_CONF`
--
ALTER TABLE `CTA_GL_CONF`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Customers_Exp`
--
ALTER TABLE `Customers_Exp`
  ADD PRIMARY KEY (`ID`,`CustomerID`,`id_compania`);

--
-- Indexes for table `Customer_Credit_Memo_Detail_Imp`
--
ALTER TABLE `Customer_Credit_Memo_Detail_Imp`
  ADD PRIMARY KEY (`DetailID`,`ID_compania`);

--
-- Indexes for table `Customer_Credit_Memo_Header_Imp`
--
ALTER TABLE `Customer_Credit_Memo_Header_Imp`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `CUST_PAY_TERM`
--
ALTER TABLE `CUST_PAY_TERM`
  ADD PRIMARY KEY (`TermID`,`ID_compania`);

--
-- Indexes for table `FAC_DET_CONF`
--
ALTER TABLE `FAC_DET_CONF`
  ADD PRIMARY KEY (`ID_compania`);

--
-- Indexes for table `InventoryAdjust_Imp`
--
ALTER TABLE `InventoryAdjust_Imp`
  ADD PRIMARY KEY (`UniqueInvAdjID`,`ID_compania`);

--
-- Indexes for table `INVOICE_GEN_DETAIL`
--
ALTER TABLE `INVOICE_GEN_DETAIL`
  ADD PRIMARY KEY (`SalesOrderNumber`,`ItemOrd`,`ID_compania`);

--
-- Indexes for table `INVOICE_GEN_HEADER`
--
ALTER TABLE `INVOICE_GEN_HEADER`
  ADD PRIMARY KEY (`ID`,`SalesOrderNumber`,`ID_compania`);

--
-- Indexes for table `INV_PRINT_CONF`
--
ALTER TABLE `INV_PRINT_CONF`
  ADD PRIMARY KEY (`ID`,`SERIAL`);

--
-- Indexes for table `ITEMS_NO_LOTES`
--
ALTER TABLE `ITEMS_NO_LOTES`
  ADD PRIMARY KEY (`ID`,`ProductID`,`no_lote`),
  ADD UNIQUE KEY `REG_KEY` (`REG_KEY`),
  ADD UNIQUE KEY `REG_KEY_2` (`REG_KEY`),
  ADD KEY `no_lote` (`no_lote`),
  ADD KEY `no_lote_UNIQUE` (`no_lote`);

--
-- Indexes for table `Jobs_Exp`
--
ALTER TABLE `Jobs_Exp`
  ADD PRIMARY KEY (`ID_compania`,`JobID`,`ID`,`ID_CompaniaOrigen`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `Job_Cost_Codes_Exp`
--
ALTER TABLE `Job_Cost_Codes_Exp`
  ADD PRIMARY KEY (`ID_compania`,`CostCodeID`,`ID_CompaniaOrigen`);

--
-- Indexes for table `Job_Phases_Exp`
--
ALTER TABLE `Job_Phases_Exp`
  ADD PRIMARY KEY (`ID_compania`,`PhaseID`,`ID_CompaniaOrigen`);

--
-- Indexes for table `MOD_MENU_CONF`
--
ALTER TABLE `MOD_MENU_CONF`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `PRI_LIST_ID`
--
ALTER TABLE `PRI_LIST_ID`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Index 1` (`IDPRICE`);

--
-- Indexes for table `PRI_LIST_ITEM`
--
ALTER TABLE `PRI_LIST_ITEM`
  ADD PRIMARY KEY (`IDPRICE`,`IDITEM`),
  ADD KEY `Index 1` (`IDPRICE`);

--
-- Indexes for table `Products_Exp`
--
ALTER TABLE `Products_Exp`
  ADD PRIMARY KEY (`ID`,`id_compania`,`ProductID`);

--
-- Indexes for table `Purchase_Detail_Exp`
--
ALTER TABLE `Purchase_Detail_Exp`
  ADD PRIMARY KEY (`ID_compania`,`PurchaseID`,`RowIndex`);

--
-- Indexes for table `Purchase_Detail_Imp`
--
ALTER TABLE `Purchase_Detail_Imp`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Purchase_Header_Exp`
--
ALTER TABLE `Purchase_Header_Exp`
  ADD PRIMARY KEY (`ID_compania`,`PurchaseID`,`PurchaseNumber`,`VendorID`);

--
-- Indexes for table `Purchase_Header_Imp`
--
ALTER TABLE `Purchase_Header_Imp`
  ADD PRIMARY KEY (`TransactionID`),
  ADD UNIQUE KEY `ID_compania_PurchaseNumber_VendorID` (`ID_compania`,`PurchaseNumber`,`VendorID`);

--
-- Indexes for table `PurOrdr_Detail_Exp`
--
ALTER TABLE `PurOrdr_Detail_Exp`
  ADD PRIMARY KEY (`ID_compania`,`RowIndex`,`TransactionID`);

--
-- Indexes for table `PurOrdr_Header_Exp`
--
ALTER TABLE `PurOrdr_Header_Exp`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `reg_traslado`
--
ALTER TABLE `reg_traslado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reportes_diarios`
--
ALTER TABLE `reportes_diarios`
  ADD PRIMARY KEY (`ID_compania`);

--
-- Indexes for table `REP_DETAIL`
--
ALTER TABLE `REP_DETAIL`
  ADD KEY `NO_REP` (`NO_REP`);

--
-- Indexes for table `REP_HEADER`
--
ALTER TABLE `REP_HEADER`
  ADD PRIMARY KEY (`ID`,`ID_compania`),
  ADD KEY `NO_REP` (`NO_REP`);

--
-- Indexes for table `REQ_DETAIL`
--
ALTER TABLE `REQ_DETAIL`
  ADD PRIMARY KEY (`NO_REQ`,`ITEM_UNIQUE_NO`),
  ADD KEY `REQ_NO` (`NO_REQ`);

--
-- Indexes for table `REQ_HEADER`
--
ALTER TABLE `REQ_HEADER`
  ADD PRIMARY KEY (`ID`,`ID_compania`),
  ADD KEY `NO_REQ` (`NO_REQ`);

--
-- Indexes for table `REQ_QUOTA`
--
ALTER TABLE `REQ_QUOTA`
  ADD PRIMARY KEY (`ID`,`NO_REQ`,`ID_compania`);

--
-- Indexes for table `REQ_RECEPT`
--
ALTER TABLE `REQ_RECEPT`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `SalesOrder_Detail_Exp`
--
ALTER TABLE `SalesOrder_Detail_Exp`
  ADD PRIMARY KEY (`ID`,`ID_compania`,`TransactionID`);

--
-- Indexes for table `SalesOrder_Detail_Imp`
--
ALTER TABLE `SalesOrder_Detail_Imp`
  ADD PRIMARY KEY (`ID`,`ID_compania`,`SalesOrderNumber`);

--
-- Indexes for table `SalesOrder_Header_Exp`
--
ALTER TABLE `SalesOrder_Header_Exp`
  ADD PRIMARY KEY (`ID_compania`,`TransactionID`,`SalesOrderNumber`);

--
-- Indexes for table `SalesOrder_Header_Imp`
--
ALTER TABLE `SalesOrder_Header_Imp`
  ADD PRIMARY KEY (`ID`,`ID_compania`,`SalesOrderNumber`);

--
-- Indexes for table `Sales_Detail_Imp`
--
ALTER TABLE `Sales_Detail_Imp`
  ADD PRIMARY KEY (`ID`,`InvoiceNumber`,`ID_compania`),
  ADD KEY `ID_compania` (`ID_compania`);

--
-- Indexes for table `Sales_Header_Imp`
--
ALTER TABLE `Sales_Header_Imp`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `InvoiceNumber` (`InvoiceNumber`),
  ADD UNIQUE KEY `ID_compania` (`ID_compania`,`InvoiceNumber`);

--
-- Indexes for table `sale_fact_pendding`
--
ALTER TABLE `sale_fact_pendding`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `no_lote` (`no_lote`);

--
-- Indexes for table `sale_pendding`
--
ALTER TABLE `sale_pendding`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `no_lote` (`no_lote`);

--
-- Indexes for table `sale_tax`
--
ALTER TABLE `sale_tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sax_company_sage`
--
ALTER TABLE `sax_company_sage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `SAX_USER`
--
ALTER TABLE `SAX_USER`
  ADD PRIMARY KEY (`id`,`email`);

--
-- Indexes for table `SHIP_INFO`
--
ALTER TABLE `SHIP_INFO`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `STOCKS`
--
ALTER TABLE `STOCKS`
  ADD PRIMARY KEY (`id`,`ID_compania`,`name`);

--
-- Indexes for table `STOCK_ITEMS_LOCATION`
--
ALTER TABLE `STOCK_ITEMS_LOCATION`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `STOCK_LOCATION`
--
ALTER TABLE `STOCK_LOCATION`
  ADD PRIMARY KEY (`id`,`location`);

--
-- Indexes for table `UNIT_MES_CONVRT`
--
ALTER TABLE `UNIT_MES_CONVRT`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Vendors_Exp`
--
ALTER TABLE `Vendors_Exp`
  ADD PRIMARY KEY (`ID_compania`,`VendorID`);

--
-- Indexes for table `Vendor_Payment_Detail_Exp`
--
ALTER TABLE `Vendor_Payment_Detail_Exp`
  ADD PRIMARY KEY (`ID_compania`,`ID_CompaniaOrigen`,`TransactionID`,`RowIndex`);

--
-- Indexes for table `Vendor_Payment_Header_Exp`
--
ALTER TABLE `Vendor_Payment_Header_Exp`
  ADD PRIMARY KEY (`ID_compania`,`ID_CompaniaOrigen`,`TransactionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CONF_NC_MOTIVO`
--
ALTER TABLE `CONF_NC_MOTIVO`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CONF_SMTP`
--
ALTER TABLE `CONF_SMTP`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CON_HEADER`
--
ALTER TABLE `CON_HEADER`
  MODIFY `idReg` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CON_REG_TRAS`
--
ALTER TABLE `CON_REG_TRAS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CREDITNOTE_DETAIL`
--
ALTER TABLE `CREDITNOTE_DETAIL`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CREDITNOTE_HEADER`
--
ALTER TABLE `CREDITNOTE_HEADER`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CTA_GL_CONF`
--
ALTER TABLE `CTA_GL_CONF`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Customers_Exp`
--
ALTER TABLE `Customers_Exp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Customer_Credit_Memo_Detail_Imp`
--
ALTER TABLE `Customer_Credit_Memo_Detail_Imp`
  MODIFY `DetailID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Customer_Credit_Memo_Header_Imp`
--
ALTER TABLE `Customer_Credit_Memo_Header_Imp`
  MODIFY `TransactionID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `InventoryAdjust_Imp`
--
ALTER TABLE `InventoryAdjust_Imp`
  MODIFY `UniqueInvAdjID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `INVOICE_GEN_HEADER`
--
ALTER TABLE `INVOICE_GEN_HEADER`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `INV_PRINT_CONF`
--
ALTER TABLE `INV_PRINT_CONF`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ITEMS_NO_LOTES`
--
ALTER TABLE `ITEMS_NO_LOTES`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Jobs_Exp`
--
ALTER TABLE `Jobs_Exp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `MOD_MENU_CONF`
--
ALTER TABLE `MOD_MENU_CONF`
  MODIFY `ID` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `PRI_LIST_ID`
--
ALTER TABLE `PRI_LIST_ID`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Products_Exp`
--
ALTER TABLE `Products_Exp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Purchase_Detail_Imp`
--
ALTER TABLE `Purchase_Detail_Imp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Purchase_Header_Imp`
--
ALTER TABLE `Purchase_Header_Imp`
  MODIFY `TransactionID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reg_traslado`
--
ALTER TABLE `reg_traslado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `REP_HEADER`
--
ALTER TABLE `REP_HEADER`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `REQ_HEADER`
--
ALTER TABLE `REQ_HEADER`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `REQ_QUOTA`
--
ALTER TABLE `REQ_QUOTA`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `REQ_RECEPT`
--
ALTER TABLE `REQ_RECEPT`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SalesOrder_Detail_Exp`
--
ALTER TABLE `SalesOrder_Detail_Exp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SalesOrder_Detail_Imp`
--
ALTER TABLE `SalesOrder_Detail_Imp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SalesOrder_Header_Imp`
--
ALTER TABLE `SalesOrder_Header_Imp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Sales_Detail_Imp`
--
ALTER TABLE `Sales_Detail_Imp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Sales_Header_Imp`
--
ALTER TABLE `Sales_Header_Imp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_fact_pendding`
--
ALTER TABLE `sale_fact_pendding`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_pendding`
--
ALTER TABLE `sale_pendding`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_tax`
--
ALTER TABLE `sale_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sax_company_sage`
--
ALTER TABLE `sax_company_sage`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SAX_USER`
--
ALTER TABLE `SAX_USER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SHIP_INFO`
--
ALTER TABLE `SHIP_INFO`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `STOCKS`
--
ALTER TABLE `STOCKS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `STOCK_ITEMS_LOCATION`
--
ALTER TABLE `STOCK_ITEMS_LOCATION`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `STOCK_LOCATION`
--
ALTER TABLE `STOCK_LOCATION`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `UNIT_MES_CONVRT`
--
ALTER TABLE `UNIT_MES_CONVRT`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



--
-- Triggers `InventoryAdjust_Imp`
--
DELIMITER $$
CREATE TRIGGER `INVENTORY_ON_ERROR` AFTER UPDATE ON `InventoryAdjust_Imp` FOR EACH ROW BEGIN
DECLARE  ORDER_Error varchar(150);
DECLARE  ORDER_Number varchar(150);
DECLARE  QTY_Pennding  int;
DECLARE  QTY_current int;
DECLARE  NEW_QTY  int;
DECLARE  Location int;
DECLARE  No_Items  int;

SET  ORDER_Error = (SELECT Error
FROM  
InventoryAdjust_Imp ORDER BY LAST_CHANGE desc limit 1);

IF (ORDER_Error > 0)

THEN

SET  ORDER_Number = (SELECT Reference
FROM  
InventoryAdjust_Imp  ORDER BY LAST_CHANGE desc limit 1);

SET Location = (SELECT location_id
FROM  
InventoryAdjust_Imp  ORDER BY LAST_CHANGE desc limit 1);


SET QTY_Pennding = (SELECT Quantity
FROM  
InventoryAdjust_Imp  ORDER BY LAST_CHANGE desc limit 1);



SET QTY_current = (SELECT qty
FROM  STOCK_ITEMS_LOCATION where id=Location);



SET NEW_QTY = ( -1 )* QTY_Pennding + QTY_current;

UPDATE STOCK_ITEMS_LOCATION SET qty=NEW_QTY where id=Location;


END IF;
END
$$
DELIMITER ;

--
-- Triggers `Products_Exp`
--
DELIMITER $$
CREATE TRIGGER `SET LOTE NUMBER` AFTER INSERT ON `Products_Exp` FOR EACH ROW BEGIN

DECLARE  ITEMID varchar(50);
DECLARE  LOTE varchar(50);
DECLARE  LOTE_QTY varchar(50);
DECLARE  Reg_KEY varchar(50);
DECLARE  IDComp INT;


SET  ITEMID = (SELECT ProductID
FROM  
Products_Exp ORDER BY ID desc limit 1);

SET  IDComp = (SELECT id_compania
FROM  
Products_Exp ORDER BY ID desc limit 1);


SET  LOTE_QTY = (SELECT QtyOnHand
FROM  
Products_Exp ORDER BY ID desc limit 1);

SET LOTE = CONCAT(ITEMID,'0000');

SET Reg_KEY = (SELECT UUID_SHORT());


INSERT INTO ITEMS_NO_LOTES  (REG_KEY, ProductID, no_lote, ID_compania) 
values (Reg_KEY, ITEMID , LOTE , IDComp);

INSERT INTO  STOCK_ITEMS_LOCATION (lote,itemID,stock,qty,location, ID_compania) 
values (LOTE, ITEMID , '1' , LOTE_QTY, '1', IDComp);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `SET LOTE NUMBER ON UPDATE` BEFORE UPDATE ON `Products_Exp` FOR EACH ROW BEGIN
/*ubico el id del item que esta siendo actualizado*/
SET  @ITEMID = (SELECT ProductID
FROM  
Products_Exp ORDER BY LAST_CHANGE desc limit 1);

SET  @IDcomp = (SELECT id_compania
FROM  
Products_Exp ORDER BY LAST_CHANGE desc limit 1);


SET @LOTEr  =  CONCAT(@ITEMID,"0000");

SET @NEW_QTY = NEW.QtyOnHand;

SET @OLD_QTY = OLD.QtyOnHand;


/*Esto solo ocurre si en PT agrego nuevos items, o la factura de compra afecta en positivo la tabla de productos*/
IF @NEW_QTY > @OLD_QTY 
THEN  

/*Guardo la variable de cantidad de aumento*/ 
SET @NOW_QTY = @NEW_QTY - @OLD_QTY ;


/* Actualizo cantidad en la ubicacion por default con la nueva cantidad*/
SET @LOC_QTY = (SELECT qty FROM STOCK_ITEMS_LOCATION  
                WHERE lote = @LOTEr 
                AND ID_compania = @IDcomp  
                AND location = '1' 
                AND stock = '1' limit 1);

SET @UPDATE_LOC_QTY = @NOW_QTY + @LOC_QTY;

UPDATE STOCK_ITEMS_LOCATION  SET qty = @UPDATE_LOC_QTY WHERE lote = @LOTEr and ID_compania = @IDcomp AND location = '1' and stock = '1';



END IF;
END
$$
DELIMITER ;


ALTER TABLE `Purchase_Header_Imp` CHANGE `Export_date` `Export_date` DATETIME NULL, CHANGE `Enviado` `Enviado` TINYINT(1) NULL, CHANGE `Error` `Error` TINYINT(1) NULL, CHANGE `ErrorPT` `ErrorPT` VARCHAR(1024) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `nota` `nota` VARCHAR(1024) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `Purchase_Header_Imp` CHANGE `VendorID` `VendorID` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_general_ci NULL, CHANGE `VendorName` `VendorName` VARCHAR(39) CHARACTER SET latin1 COLLATE latin1_general_ci NULL, CHANGE `AP_Account` `AP_Account` VARCHAR(15) CHARACTER SET latin1 COLLATE latin1_general_ci NULL;
ALTER TABLE `Purchase_Detail_Imp` CHANGE `GL_Acct` `GL_Acct` VARCHAR(15) CHARACTER SET latin1 COLLATE latin1_general_ci NULL;
ALTER TABLE `INV_EVENT_LOG` ADD `Qty` DECIMAL(16,5) NOT NULL AFTER `PurchaseOrderNumber`, ADD `unit_price` DECIMAL(16,5) NOT NULL AFTER `Qty`;
ALTER TABLE `INV_EVENT_LOG` ADD `Type` VARCHAR(30) NOT NULL AFTER `User`;
ALTER TABLE `INV_EVENT_LOG` ADD `referencia` VARCHAR(45) NOT NULL AFTER `ID`;
ALTER TABLE `REQ_DETAIL` CHANGE COLUMN `UNIDAD` `UNIDAD` VARCHAR(10) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ;

ALTER TABLE `ACIWEB_test`.`Customers_Exp` 
CHANGE COLUMN `SalesRepID` `SalesRepID` VARCHAR(20) NULL ,
CHANGE COLUMN `SalesRepName` `SalesRepName` VARCHAR(56) NULL ,
CHANGE COLUMN `custom_field1` `custom_field1` VARCHAR(40) NULL ,
CHANGE COLUMN `custom_field2` `custom_field2` VARCHAR(40) NULL ,
CHANGE COLUMN `Custom_field3` `Custom_field3` VARCHAR(40) NULL ,
CHANGE COLUMN `Custom_field4` `Custom_field4` VARCHAR(40) NULL ,
CHANGE COLUMN `Custom_field5` `Custom_field5` VARCHAR(40) NULL ;
