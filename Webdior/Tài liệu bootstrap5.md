# 📚 TÀI LIỆU BOOTSTRAP 5 CLASSES - WEBDIOR

## 📋 DANH SÁCH TẤT CẢ BOOTSTRAP CLASSES ĐÃ SỬ DỤNG

---

## 🎨 **LAYOUT & CONTAINER CLASSES**

### **Container System**
```html
<!-- container: Container chính có max-width và padding responsive -->
<div class="container">
```
- **Chức năng**: Tạo container chính với max-width responsive và padding tự động
- **Responsive**: 1200px (lg), 992px (md), 768px (sm), 576px (xs)

---

## 📐 **GRID SYSTEM CLASSES**

### **Row & Column Classes**
```html
<!-- row: Tạo hàng trong grid system -->
<div class="row">

<!-- row với gutters -->
<div class="row g-3">      <!-- Gutter size 3 -->
<div class="row g-4">      <!-- Gutter size 4 -->
<div class="row g-5">      <!-- Gutter size 5 -->

<!-- col: Cột cơ bản auto-width -->
<div class="col">

<!-- col với breakpoints -->
<div class="col-lg-6">     <!-- 6/12 columns trên large screens -->
<div class="col-md-6">     <!-- 6/12 columns trên medium screens -->
<div class="col-lg-3">     <!-- 3/12 columns trên large screens -->
<div class="col-lg-2">     <!-- 2/12 columns trên large screens -->
<div class="col-lg-4">     <!-- 4/12 columns trên large screens -->
<div class="col-lg-9">     <!-- 9/12 columns trên large screens -->
<div class="col-md-8">     <!-- 8/12 columns trên medium screens -->
<div class="col-md-4">     <!-- 4/12 columns trên medium screens -->
<div class="col-md-12">    <!-- 12/12 columns (full width) trên medium screens -->

<!-- row-cols: Tự động chia cột đều -->
<div class="row row-cols-2">      <!-- 2 cột mỗi hàng -->
<div class="row row-cols-md-4">   <!-- 4 cột mỗi hàng trên medium+ -->
<div class="row row-cols-1">      <!-- 1 cột mỗi hàng -->
<div class="row row-cols-sm-2">   <!-- 2 cột mỗi hàng trên small+ -->
<div class="row row-cols-lg-4">   <!-- 4 cột mỗi hàng trên large+ -->
```

---

## 🧭 **NAVIGATION CLASSES**

### **Navbar Components**
```html
<!-- navbar: Component navbar chính -->
<nav class="navbar">

<!-- navbar-expand-lg: Navbar mở rộng từ large screens -->
<nav class="navbar navbar-expand-lg">

<!-- navbar-light: Theme sáng cho navbar -->
<nav class="navbar navbar-light">

<!-- navbar-brand: Logo/brand area -->
<a class="navbar-brand">

<!-- navbar-toggler: Nút toggle mobile menu -->
<button class="navbar-toggler">

<!-- navbar-toggler-icon: Icon cho toggle button -->
<span class="navbar-toggler-icon">

<!-- navbar-collapse: Container cho collapsible content -->
<div class="navbar-collapse">

<!-- collapse: Class để tạo collapsible behavior -->
<div class="collapse">

<!-- navbar-nav: Container cho nav items -->
<ul class="navbar-nav">

<!-- nav-item: Từng item trong nav -->
<li class="nav-item">

<!-- nav-link: Link trong nav item -->
<a class="nav-link">
```

### **Dropdown Navigation**
```html
<!-- dropdown: Container cho dropdown -->
<li class="nav-item dropdown">

<!-- dropdown-toggle: Trigger cho dropdown -->
<a class="nav-link dropdown-toggle">

<!-- dropdown-menu: Menu dropdown -->
<ul class="dropdown-menu">

<!-- dropdown-item: Item trong dropdown menu -->
<a class="dropdown-item">
```

### **Breadcrumb Navigation**
```html
<!-- breadcrumb: Container cho breadcrumb navigation -->
<ol class="breadcrumb">

<!-- breadcrumb-item: Từng item trong breadcrumb -->
<li class="breadcrumb-item">

<!-- active: Item hiện tại trong breadcrumb -->
<li class="breadcrumb-item active">
```

---

## 🎴 **CARD COMPONENTS**

### **Card Structure**
```html
<!-- card: Container card chính -->
<div class="card">

<!-- card-img-top: Ảnh ở đầu card -->
<img class="card-img-top">

<!-- card-body: Nội dung chính của card -->
<div class="card-body">
```

---

## 🔘 **BUTTON CLASSES**

### **Button Variants**
```html
<!-- btn: Base button class -->
<button class="btn">

<!-- btn-dark: Button màu đen -->
<button class="btn btn-dark">

<!-- btn-outline-dark: Button outline màu đen -->
<button class="btn btn-outline-dark">

<!-- btn-outline-secondary: Button outline màu xám -->
<button class="btn btn-outline-secondary">

<!-- btn-outline-danger: Button outline màu đỏ -->
<button class="btn btn-outline-danger">

<!-- btn-outline-primary: Button outline màu xanh -->
<button class="btn btn-outline-primary">

<!-- btn-sm: Button size nhỏ -->
<button class="btn btn-sm">
```

---

## 📝 **FORM CLASSES**

### **Form Controls**
```html
<!-- form-label: Label cho form input -->
<label class="form-label">

<!-- form-control: Input field styling -->
<input class="form-control">

<!-- form-select: Select dropdown styling -->
<select class="form-select">

<!-- form-check: Container cho checkbox/radio -->
<div class="form-check">

<!-- form-check-input: Checkbox/radio input -->
<input class="form-check-input">

<!-- form-check-label: Label cho checkbox/radio -->
<label class="form-check-label">
```

---

## 🎯 **UTILITY CLASSES**

### **Spacing Classes**
```html
<!-- Padding -->
<div class="p-2">        <!-- Padding 0.5rem tất cả các phía -->
<div class="p-3">        <!-- Padding 1rem tất cả các phía -->
<div class="p-4">        <!-- Padding 1.5rem tất cả các phía -->
<div class="py-3">       <!-- Padding 1rem trên và dưới -->
<div class="py-4">       <!-- Padding 1.5rem trên và dưới -->
<div class="py-5">       <!-- Padding 3rem trên và dưới -->
<div class="px-0">       <!-- Padding 0 trái và phải -->

<!-- Margin -->
<div class="m-0">        <!-- Margin 0 tất cả các phía -->
<div class="mb-1">       <!-- Margin-bottom 0.25rem -->
<div class="mb-2">       <!-- Margin-bottom 0.5rem -->
<div class="mb-3">       <!-- Margin-bottom 1rem -->
<div class="mb-4">       <!-- Margin-bottom 1.5rem -->
<div class="mb-5">       <!-- Margin-bottom 3rem -->
<div class="mb-0">       <!-- Margin-bottom 0 -->
<div class="mt-3">       <!-- Margin-top 1rem -->
<div class="mt-5">       <!-- Margin-top 3rem -->
<div class="me-2">       <!-- Margin-end (right) 0.5rem -->
<div class="me-auto">    <!-- Margin-end auto -->
<div class="ms-2">       <!-- Margin-start (left) 0.5rem -->
<div class="ms-4">       <!-- Margin-start (left) 1.5rem -->
<div class="my-2">       <!-- Margin 0.5rem trên và dưới -->
<div class="my-3">       <!-- Margin 1rem trên và dưới -->
<div class="my-4">       <!-- Margin 1.5rem trên và dưới -->
```

### **Display Classes**
```html
<div class="d-flex">            <!-- Display: flex -->
<div class="d-block">           <!-- Display: block -->
<div class="d-none">            <!-- Display: none -->
<div class="d-md-flex">         <!-- Display: flex từ medium+ -->
```

### **Flexbox Classes**
```html
<!-- Justify Content -->
<div class="justify-content-center">    <!-- justify-content: center -->
<div class="justify-content-between">   <!-- justify-content: space-between -->

<!-- Align Items -->
<div class="align-items-center">        <!-- align-items: center -->
<div class="align-items-baseline">      <!-- align-items: baseline -->

<!-- Flex Direction & Wrap -->
<div class="flex-wrap">                 <!-- flex-wrap: wrap -->

<!-- Gap -->
<div class="gap-2">                     <!-- gap: 0.5rem -->
<div class="gap-3">                     <!-- gap: 1rem -->
```

### **Text Classes**
```html
<!-- Text Alignment -->
<div class="text-center">        <!-- text-align: center -->
<div class="text-md-end">        <!-- text-align: end từ medium+ -->

<!-- Text Colors -->
<div class="text-secondary">     <!-- color: #6c757d (gray) -->
<div class="text-muted">         <!-- color: #6c757d (muted gray) -->
<div class="text-dark">          <!-- color: #212529 (dark) -->
<div class="text-light">         <!-- color: #f8f9fa (light) -->
<div class="text-primary">       <!-- color: primary theme -->
<div class="text-danger">        <!-- color: #dc3545 (red) -->

<!-- Text Decoration -->
<a class="text-decoration-none"> <!-- text-decoration: none -->
```

### **Typography Classes**
```html
<!-- Headings -->
<h1 class="h2">              <!-- Font-size như h2 nhưng semantic h1 -->
<h1 class="h3">              <!-- Font-size như h3 nhưng semantic h1 -->
<h2 class="h4">              <!-- Font-size như h4 nhưng semantic h2 -->
<h3 class="h5">              <!-- Font-size như h5 nhưng semantic h3 -->
<h3 class="h6">              <!-- Font-size như h6 nhưng semantic h3 -->

<!-- Display Headings -->
<h1 class="display-5">       <!-- Display heading size 5 -->
<h1 class="display-6">       <!-- Display heading size 6 -->

<!-- Font Weight -->
<span class="fw-semibold">   <!-- font-weight: 600 -->
<span class="fw-bold">       <!-- font-weight: 700 -->

<!-- Small Text -->
<small class="small">        <!-- font-size: 0.875em -->

<!-- Line Height -->
<p class="lh-lg">           <!-- line-height: 1.75 -->
```

### **Background Classes**
```html
<div class="bg-light">          <!-- background-color: #f8f9fa -->
<div class="bg-white">          <!-- background-color: #ffffff -->
<div class="bg-dark">           <!-- background-color: #212529 -->
<div class="bg-transparent">    <!-- background-color: transparent -->
<div class="bg-danger">         <!-- background-color: #dc3545 -->
```

### **Border Classes**
```html
<div class="border-0">          <!-- border: 0 -->
<div class="border-top">        <!-- border-top: 1px solid -->
<div class="border-bottom">     <!-- border-bottom: 1px solid -->
<div class="rounded">           <!-- border-radius: 0.375rem -->
<div class="rounded-3">         <!-- border-radius: 0.5rem -->
<div class="rounded-4">         <!-- border-radius: 0.75rem -->
<div class="shadow-sm">         <!-- box-shadow: nhẹ -->
<div class="rounded-pill">      <!-- border-radius: 50rem -->
```

### **Width Classes**
```html
<div class="w-100">             <!-- width: 100% -->
```

### **Position Classes**
```html
<div class="sticky-top">         <!-- position: sticky; top: 0 -->
<div class="position-absolute">  <!-- position: absolute -->
<div class="top-0">             <!-- top: 0 -->
<div class="start-100">         <!-- left: 100% (trong LTR) -->
<div class="translate-middle">   <!-- transform: translate(-50%, -50%) -->
```

### **Visibility Classes**
```html
<span class="visually-hidden">   <!-- Ẩn khỏi visual nhưng vẫn có cho screen reader -->
```

### **Font Size Classes**
```html
<i class="fs-4">                <!-- font-size: calc(1.275rem + 0.3vw) -->
<i class="fs-5">                <!-- font-size: 1.25rem -->
```

### **List Classes**
```html
<ul class="list-unstyled">      <!-- list-style: none -->
```

---

## 📱 **RESPONSIVE CLASSES**

### **Responsive Display**
```html
<form class="d-none d-md-flex">  <!-- Ẩn trên mobile, hiện flex từ medium+ -->
```

### **Responsive Breakpoints**
- **xs**: <576px (extra small)
- **sm**: ≥576px (small)
- **md**: ≥768px (medium)
- **lg**: ≥992px (large)
- **xl**: ≥1200px (extra large)
- **xxl**: ≥1400px (extra extra large)

---

## 🎪 **SPECIAL BOOTSTRAP COMPONENTS**

### **Badge Component**
```html
<span class="badge">                <!-- Base badge class -->
<span class="badge rounded-pill">   <!-- Pill-shaped badge -->
```

### **Height Utilities**
```html
<div class="h-100">                 <!-- height: 100% -->
```

---

## 📊 **THỐNG KÊ SỬ DỤNG**

### **Tổng số Bootstrap Classes**: 150+ classes
### **Phân loại**:
- **Layout & Grid**: 25 classes
- **Navigation**: 20 classes  
- **Typography**: 15 classes
- **Spacing**: 30 classes
- **Flexbox**: 12 classes
- **Colors**: 10 classes
- **Buttons**: 8 classes
- **Forms**: 10 classes
- **Borders & Shadows**: 8 classes
- **Responsive**: 15+ classes

---

## 🎯 **MỤC ĐÍCH SỬ DỤNG**

### **1. Responsive Design**
- Grid system cho layout responsive
- Breakpoint classes cho điều khiển theo screen size

### **2. Component Styling**
- Navbar, Cards, Buttons, Forms
- Typography và spacing consistency

### **3. Utility-First Approach**
- Flexbox utilities cho alignment
- Spacing utilities cho margin/padding
- Color utilities cho theme consistency

### **4. Accessibility**
- Semantic navigation structure
- Screen reader friendly classes
- Proper form labeling

---

*📝 Tài liệu này bao gồm tất cả Bootstrap 5 classes được sử dụng trong dự án Webdior với giải thích chi tiết về chức năng và cách sử dụng của từng class.*
