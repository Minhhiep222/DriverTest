import {authMiddleware} from '@/middlewares/auth';
import {createRouter, createWebHistory} from 'vue-router';
import {useStore} from 'vuex';

const router = createRouter({
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('@/app/[auth]/Login.vue'),
      beforeEnter: authMiddleware.checkLoggedIn,
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('@/app/[auth]/Register.vue'),
      beforeEnter: authMiddleware.checkLoggedIn,
    },
    {
      path: '/reset-password',
      name: 'reset-password',
      component: () => import('@/app/[auth]/ResetPass.vue'),
    },
    {
      path: '/reset-password',
      name: 'reset-password',
      component: () => import('@/app/[auth]/ResetPass.vue'),
    },

    /**
     * Header only layout
     */
    {
      name: 'HeaderOnly',
      component: () => import('@/layout/HeaderOnly.vue'),
      children: [
        {
          path: '//',
          name: 'home',
          // requiresAuth: false,
          component: () => import('@/app/Home.vue'),
        },
        {
          path: '/me',
          name: 'me',
          // requiresAuth: false,
          component: () => import('@/app/[me]/Me.vue'),
        },
        {
          path: '/drive-management',
          name: 'drive-management',
          component: () => import('@/app/[driver]/TestDrivePrograms.vue'),
        },
        {
          path: '/drive-reviews',
          name: 'drive-reviews',
          component: () => import('@/app/[admin]/[driver]/DriverMngt.vue'),
        },
        {
          path: '/about',
          name: 'about',
          component: () => import('@/app/AboutView.vue'),
        },
        // {
        //   name: 'DeafaultLayout',
        //   component: () => import('@/layout/DefaultLayout.vue'),
        //   children: [
        //     {
        //       path: '/admin',
        //       name: 'admin',
        //       component: () => import('@/app/[admin]/Admin.vue'),
        //     },
        //     {
        //       path: '/profile',
        //       name: 'profile',
        //       component: () => import('@/app/Profile-showroom.vue'),
        //     },
        //     {
        //       path: '/booking-user',
        //       name: 'booking-user',
        //       component: () => import('@/app/booking-user.vue'),
        //     },
        //   ],
        {
          path: '/user-management',
          name: 'user-management',
          meta: {requiresAuth: true},
          component: () => import('@/app/[admin]/[user]/UserMngt.vue'),
          beforeEnter: authMiddleware.requireAdmin,
        },
        {
          path: '/customer-management',
          name: 'customer-management',
          component: () => import('@/app/[admin]/[customer]/CustomerMngt.vue'),
          beforeEnter: authMiddleware.requireUser,
        },
        {
          path: '/:id/log-books',
          name: 'log-books',
          component: () => import('@/app/[me]/Deatail.vue'),
        },

        {
          path: '/:id/reviews',
          name: 'reviews',
          component: () => import('@/app/[admin]/[driver]/[handle]/Detail.vue'),
          beforeEnter: authMiddleware.requireAdmin,
        },

        {
          path: '/:id/detail',
          name: 'deatail',
          component: () => import('@/app/[dashboard]/Deatail.vue'),
        },

        {
          path: '/books',
          name: 'books',
          component: () => import('@/app/[driver]/TestDriveDetailsUser.vue'),
          beforeEnter: authMiddleware.requireUser,
        },
        {
          path: '/admin',
          name: 'admin',
          requiresAuth: true,
          component: () => import('@/app/[admin]/Admin.vue'),
          beforeEnter: authMiddleware.requireAdmin,
        },
        {
          path: '/Piority-User',
          name: 'Piority-User',
          component: () => import('@/app/[admin]/PiorityUser.vue'),
          beforeEnter: authMiddleware.requireAdmin,
        },
        {
          path: '/:id/booking',
          name: 'Booking-Form',
          meta: {requiresAuth: true},
          component: () => import('@/app/[Reservation]/BookingForm.vue'),
        },
        {
          path: '/settings',
          name: 'settings',
          component: () => import('@/app/[Reservation]/Setting.vue'),
        },

        {
          path: '/bookings',
          name: 'bookings',
          component: () => import('@/app/booking-user.vue'),
        },
      ],
    },

    /**
     * Default layout
     */
    {
      name: 'DeafaultLayout',
      component: () => import('@/layout/DefaultLayout.vue'),
      children: [],
    },
  ],
  history: createWebHistory(import.meta.env.BASE_URL),
});

export default router;
